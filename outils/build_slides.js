// Génère un PowerPoint MODIFIABLE (zones de texte, tableaux et notes natifs) à partir d'un slides.md.
// Usage : node outils/build_slides.js semaines/S01-web-html/slides.md build/slides/S01.pptx
//
// Syntaxe reconnue dans slides.md (syntaxe Marp) :
//   ---                          séparateur de slides
//   <!-- _class: titre -->       slide de titre (fond bleu)   ·   <!-- _class: question -->
//   <!-- texte libre -->         notes de l'orateur
//   # / ## / ###, paragraphes, listes * et 1., ```code```, tableaux |...|, > citation
//   <div class="piege"> ... </div>  et  <div class="regle"> ... </div>
//   **gras**, *italique*, `code` dans le texte

const fs = require('fs');
const path = require('path');
const pptxgen = require('pptxgenjs');

const [, , input, output] = process.argv;
if (!input || !output) {
  console.error('Usage : node build_slides.js slides.md sortie.pptx');
  process.exit(1);
}

// ---- Palette (identique au thème CSS du cours) ----
const C = {
  blue: '1D4ED8', blueDark: '1E3A8A', ink: '1E293B', muted: '64748B', accent: 'F59E0B',
  codeBg: 'F1F5F9', codeBorder: 'CBD5E1', codeInline: 'BE123C',
  trapBg: 'FEF2F2', trapInk: '991B1B', ruleBg: 'ECFDF5', ruleInk: '065F46',
  quoteBg: 'EFF6FF', questionBg: 'EFF6FF', white: 'FFFFFF', rowAlt: 'F8FAFC',
};
const FONT = 'Calibri';
const MONO = 'Courier New';

const W = 13.333, H = 7.5;
const MX = 0.6;                 // marge gauche / droite
const CW = W - 2 * MX;          // largeur utile
const TOP = 1.55, BOTTOM = 6.85; // zone du contenu

// ---------------------------------------------------------------- lecture
const raw = fs.readFileSync(input, 'utf8').replace(/\r\n/g, '\n');
let body = raw;
let footer = '';
const fm = raw.match(/^---\n([\s\S]*?)\n---\n/);
if (fm) {
  const f = fm[1].match(/footer:\s*'([^']*)'/);
  if (f) footer = f[1];
  body = raw.slice(fm[0].length);
}

// Découper en slides sur les lignes '---' hors des blocs de code
function splitSlides(text) {
  const slides = [];
  let current = [];
  let inCode = false;
  for (const line of text.split('\n')) {
    if (line.startsWith('```')) inCode = !inCode;
    if (!inCode && line.trim() === '---') {
      slides.push(current.join('\n'));
      current = [];
    } else {
      current.push(line);
    }
  }
  slides.push(current.join('\n'));
  return slides.filter((s) => s.trim() !== '');
}

// Transformer le Markdown d'une slide en blocs
function parseSlide(text) {
  const slide = { cls: '', notes: [], blocks: [], hideFooter: false };
  // commentaires : directives ou notes
  text = text.replace(/<!--([\s\S]*?)-->/g, (_, c) => {
    const content = c.trim();
    const cls = content.match(/^_class:\s*(\w+)/);
    if (cls) slide.cls = cls[1];
    else if (/^_footer:/.test(content) || /^_paginate:/.test(content)) slide.hideFooter = true;
    else slide.notes.push(content);
    return '';
  });

  const lines = text.split('\n');
  let i = 0;
  let box = null; // bloc piège / règle en cours
  const push = (b) => (box ? box.blocks : slide.blocks).push(b);

  while (i < lines.length) {
    const line = lines[i];
    const t = line.trim();

    if (t === '') { i++; continue; }

    const div = t.match(/^<div class="(\w+)">$/);
    if (div) { box = { type: 'box', kind: div[1], blocks: [] }; i++; continue; }
    if (t === '</div>') { if (box) slide.blocks.push(box); box = null; i++; continue; }

    if (t.startsWith('```')) {
      const code = [];
      i++;
      while (i < lines.length && !lines[i].trim().startsWith('```')) code.push(lines[i++]);
      i++;
      push({ type: 'code', lines: code });
      continue;
    }
    const h = t.match(/^(#{1,3})\s+(.*)$/);
    if (h) { push({ type: 'h' + h[1].length, text: h[2] }); i++; continue; }

    if (t.startsWith('|')) {
      const rows = [];
      while (i < lines.length && lines[i].trim().startsWith('|')) {
        const r = lines[i].trim();
        if (!/^\|[\s:|-]+\|$/.test(r)) {
          rows.push(r.slice(1, -1).split(/(?<!\\)\|/).map((c) => c.trim().replace(/\\\|/g, '|')));
        }
        i++;
      }
      push({ type: 'table', rows });
      continue;
    }
    if (/^([*-]|\d+\.)\s+/.test(t)) {
      const items = [];
      const ordered = /^\d+\./.test(t);
      while (i < lines.length && /^\s*([*-]|\d+\.)\s+/.test(lines[i])) {
        const m = lines[i].match(/^(\s*)([*-]|\d+\.)\s+(.*)$/);
        items.push({ text: m[3].replace(/^\[ \]\s*/, '☐ ').replace(/^\[x\]\s*/i, '☑ '), indent: m[1].length >= 2 ? 1 : 0 });
        i++;
        // lignes de continuation indentées
        while (i < lines.length && /^\s{2,}\S/.test(lines[i]) && !/^\s*([*-]|\d+\.)\s+/.test(lines[i])) {
          items[items.length - 1].text += ' ' + lines[i].trim();
          i++;
        }
      }
      push({ type: 'list', ordered, items });
      continue;
    }
    if (t.startsWith('>')) {
      const q = [];
      while (i < lines.length && lines[i].trim().startsWith('>')) q.push(lines[i++].trim().replace(/^>\s?/, ''));
      push({ type: 'quote', text: q.join(' ') });
      continue;
    }
    // paragraphe
    const p = [t];
    i++;
    while (i < lines.length && lines[i].trim() !== '' && !/^(#|```|\||>|[*-]\s|\d+\.\s|<)/.test(lines[i].trim())) {
      p.push(lines[i++].trim());
    }
    push({ type: 'p', text: p.join(' ') });
  }
  return slide;
}

// ---------------------------------------------------------------- texte enrichi
// "**gras** et `code`" → runs pptxgenjs
function runs(text, base) {
  const out = [];
  const re = /(\*\*[^*]+\*\*|``\s?.+?\s?``|`[^`]+`|\*[^*\s][^*]*\*)/g;
  let last = 0;
  let m;
  while ((m = re.exec(text)) !== null) {
    if (m.index > last) out.push({ text: text.slice(last, m.index), options: { ...base } });
    const tok = m[0];
    if (tok.startsWith('**')) out.push({ text: tok.slice(2, -2), options: { ...base, bold: true } });
    else if (tok.startsWith('`')) out.push({ text: tok.startsWith('``') ? tok.slice(2, -2).trim() : tok.slice(1, -1), options: { ...base, fontFace: MONO, fontSize: base.fontSize ? Math.round(base.fontSize * 0.88) : undefined, color: base.codeColor || C.codeInline } });
    else out.push({ text: tok.slice(1, -1), options: { ...base, italic: true } });
    last = m.index + tok.length;
  }
  if (last < text.length) out.push({ text: text.slice(last), options: { ...base } });
  return out.map((r) => { delete r.options.codeColor; return r; });
}
const plain = (text) => text.replace(/\*\*|`|\*/g, '');

// ---------------------------------------------------------------- mesures
const lineH = (size, factor = 1.25) => (size * factor) / 72;
function wrapLines(text, size, width, mono = false) {
  const cw = (mono ? 0.6 : 0.5) * size / 72;
  const perLine = Math.max(8, Math.floor(width / cw));
  return Math.max(1, Math.ceil(plain(text).length / perLine));
}

function measure(block, s, width = CW) {
  const body = 22 * s;
  switch (block.type) {
    case 'h1': return wrapLines(block.text, 30 * s, width) * lineH(30 * s) + 0.1;
    case 'h2': return wrapLines(block.text, 26 * s, width) * lineH(26 * s) + 0.1;
    case 'h3': return wrapLines(block.text, 22 * s, width) * lineH(22 * s) + 0.05;
    case 'p': return wrapLines(block.text, body, width) * lineH(body) + 0.08;
    case 'quote': return wrapLines(block.text, body, width - 0.6) * lineH(body) + 0.4;
    case 'list':
      return block.items.reduce((h, it) => h + wrapLines(it.text, body, width - 0.5 - it.indent * 0.4) * lineH(body) + 0.08, 0.05);
    case 'code': {
      const size = codeSize(block, s, width);
      return block.lines.length * lineH(size, 1.18) + 0.3;
    }
    case 'table': return tableLayout(block, s, width).height;
    case 'box': return block.blocks.reduce((h, b) => h + measure(b, s, width - 0.5) + 0.05, 0.3);
    default: return 0;
  }
}

function codeSize(block, s, width) {
  const longest = Math.max(10, ...block.lines.map((l) => l.length));
  const fit = ((width - 0.4) * 72) / (0.6 * longest);   // taille maximale pour que la plus longue ligne tienne
  return Math.max(9, Math.min(16 * s, fit));
}

function tableLayout(block, s, width) {
  const size = Math.max(10, 16 * s);
  const cols = block.rows[0].length;
  const maxLen = Array.from({ length: cols }, (_, c) =>
    Math.max(4, ...block.rows.map((r) => plain(r[c] || '').length)));
  const total = maxLen.reduce((a, b) => a + Math.min(b, 60), 0);
  const colW = maxLen.map((l) => Math.max(1.0, (Math.min(l, 60) / total) * width));
  const scale = width / colW.reduce((a, b) => a + b, 0);
  const cw = colW.map((w) => w * scale);
  let height = 0;
  const rowH = block.rows.map((r) => {
    const lines = Math.max(...r.map((cell, c) => wrapLines(cell, size, cw[c] - 0.15)));
    const h = lines * lineH(size, 1.2) + 0.14;
    height += h;
    return h;
  });
  return { size, cw, rowH, height };
}

// ---------------------------------------------------------------- dessin
function drawBlocks(pres, slide, blocks, x, y, width, s, color = C.ink) {
  for (const b of blocks) {
    const h = measure(b, s, width);
    const body = 22 * s;
    const base = { fontFace: FONT, fontSize: body, color };

    if (b.type === 'h1' || b.type === 'h2' || b.type === 'h3') {
      const size = { h1: 30, h2: 26, h3: 22 }[b.type] * s;
      slide.addText(runs(b.text, { ...base, fontSize: size, bold: true, color: b.type === 'h3' ? color : C.blue }),
        { x, y, w: width, h, margin: 0, valign: 'top', isTextBox: true });
    } else if (b.type === 'p') {
      slide.addText(runs(b.text, base), { x, y, w: width, h, margin: 0, valign: 'top', isTextBox: true });
    } else if (b.type === 'quote') {
      slide.addText(runs(b.text, { ...base, italic: true }),
        { x, y, w: width, h, margin: [8, 14, 8, 14], fill: { color: C.quoteBg }, valign: 'middle', isTextBox: true });
    } else if (b.type === 'list') {
      const items = b.items.map((it, n) => ({
        text: '',
        runs: runs(it.text, base),
        options: {
          bullet: b.ordered ? { type: 'number' } : { indent: 18 },
          indentLevel: it.indent,
          paraSpaceAfter: 5,
          breakLine: n < b.items.length - 1,
        },
      }));
      // pptxgenjs : un paragraphe = une suite de runs ; les options de puce vont sur le premier run
      const flat = [];
      items.forEach((it) => {
        it.runs.forEach((r, k) => {
          // options de paragraphe sur le premier run seulement (voir cleanParagraphs plus bas)
          const opts = { ...r.options };
          if (k === 0) Object.assign(opts, { bullet: it.options.bullet, indentLevel: it.options.indentLevel, paraSpaceAfter: 5 });
          if (k === it.runs.length - 1) opts.breakLine = it.options.breakLine;
          flat.push({ text: r.text, options: opts });
        });
      });
      slide.addText(flat, { x, y, w: width, h, margin: 0, valign: 'top', isTextBox: true });
    } else if (b.type === 'code') {
      const size = codeSize(b, s, width);
      const text = b.lines.map((l, n) => ({ text: l === '' ? ' ' : l, options: { breakLine: n < b.lines.length - 1 } }));
      slide.addText(text, {
        x, y, w: width, h, margin: [8, 12, 8, 12], fontFace: MONO, fontSize: size, color: C.ink,
        fill: { color: C.codeBg }, line: { color: C.codeBorder, width: 0.75 }, valign: 'top',
        shape: pres.ShapeType.roundRect, rectRadius: 0.08, isTextBox: true,
      });
    } else if (b.type === 'table') {
      const L = tableLayout(b, s, width);
      const rows = b.rows.map((r, ri) => r.map((cell) => ({
        text: runs(cell, { fontFace: FONT, fontSize: L.size, color: ri === 0 ? C.white : C.ink, bold: ri === 0,
          codeColor: ri === 0 ? C.white : C.codeInline }),
        options: { fill: { color: ri === 0 ? C.blue : (ri % 2 === 0 ? C.rowAlt : C.white) }, valign: 'middle' },
      })));
      slide.addTable(rows, { x, y, w: width, colW: L.cw, rowH: L.rowH, border: { type: 'solid', color: 'E2E8F0', pt: 0.75 }, margin: [3, 6, 3, 6] });
    } else if (b.type === 'box') {
      const trap = b.kind === 'piege';
      slide.addShape(pres.ShapeType.roundRect, { x, y, w: width, h, rectRadius: 0.08, fill: { color: trap ? C.trapBg : C.ruleBg }, line: { color: trap ? C.trapBg : C.ruleBg } });
      drawBlocks(pres, slide, b.blocks, x + 0.25, y + 0.15, width - 0.5, s, trap ? C.trapInk : C.ruleInk);
    }
    y += h + 0.18;
  }
  return y;
}

// ---------------------------------------------------------------- construction
const pres = new pptxgen();
pres.layout = 'LAYOUT_WIDE';
pres.author = 'Amani Selmi, PhD-Engineer';
pres.title = footer || path.basename(path.dirname(input));

const slides = splitSlides(body).map(parseSlide);

slides.forEach((sd, index) => {
  const slide = pres.addSlide();
  const blocks = [...sd.blocks];

  if (sd.cls === 'titre') {
    slide.background = { color: C.blue };
    let y = 2.2;
    for (const b of blocks) {
      const size = b.type === 'h1' ? 44 : b.type === 'h2' ? 28 : 20;
      const h = wrapLines(b.text, size, CW) * lineH(size) + 0.15;
      slide.addText(runs(b.text, { fontFace: FONT, fontSize: size, color: C.white, bold: b.type !== 'p' || /^\*\*/.test(b.text) }),
        { x: MX, y, w: CW, h, margin: 0, valign: 'top', isTextBox: true });
      y += h + (b.type === 'h1' ? 0.2 : 0.35);
    }
  } else if (sd.cls === 'question') {
    slide.background = { color: C.questionBg };
    let y = 1.6;
    for (const b of blocks) {
      if (b.type === 'code') {
        y = drawBlocks(pres, slide, [b], MX + 1, y, CW - 2, 1.1);
        continue;
      }
      const size = b.type.startsWith('h') ? 36 : 26;
      const h = wrapLines(b.text, size, CW - 1) * lineH(size) + 0.2;
      slide.addText(runs(b.text, { fontFace: FONT, fontSize: size, color: b.type.startsWith('h') ? C.blue : C.ink, bold: b.type.startsWith('h') }),
        { x: MX + 0.5, y, w: CW - 1, h, margin: 0, align: 'center', valign: 'top', isTextBox: true });
      y += h + 0.3;
    }
  } else {
    slide.background = { color: C.white };
    // Titre = premier titre de la slide
    if (blocks.length && /^h[12]$/.test(blocks[0].type)) {
      const t = blocks.shift();
      slide.addText(runs(t.text, { fontFace: FONT, fontSize: 32, bold: true, color: C.blue }),
        { x: MX, y: 0.45, w: CW, h: 0.9, margin: 0, valign: 'middle', fit: 'shrink', isTextBox: true });
    }
    // Taille du texte : on réduit jusqu'à ce que tout tienne
    let s = 1;
    const available = BOTTOM - TOP;
    const total = (k) => blocks.reduce((sum, b) => sum + measure(b, k) + 0.18, 0);
    while (s > 0.6 && total(s) > available) s -= 0.04;
    drawBlocks(pres, slide, blocks, MX, TOP, CW, s);
  }

  if (!sd.hideFooter) {
    const dark = sd.cls === 'titre';
    slide.addText(footer, { x: MX, y: H - 0.45, w: CW - 1, h: 0.3, margin: 0, fontFace: FONT, fontSize: 10, color: dark ? 'DBEAFE' : C.muted, isTextBox: true });
    slide.addText(String(index + 1), { x: W - MX - 0.8, y: H - 0.45, w: 0.8, h: 0.3, margin: 0, align: 'right', fontFace: FONT, fontSize: 11, color: dark ? 'DBEAFE' : C.muted, isTextBox: true });
  }
  if (sd.notes.length) slide.addNotes(sd.notes.join('\n\n'));
});

// pptxgenjs écrit un <a:pPr> avant CHAQUE run d'un paragraphe : le dernier gagne et efface la puce.
// On garde seulement le premier <a:pPr> de chaque paragraphe.
function cleanParagraphs(xml) {
  return xml.replace(/<a:p>([\s\S]*?)<\/a:p>/g, (paragraph, inner) => {
    let seen = false;
    const cleaned = inner.replace(/<a:pPr\b[^>]*?(?:\/>|>[\s\S]*?<\/a:pPr>)/g, (pPr) => {
      if (seen) return '';
      seen = true;
      return pPr;
    });
    return `<a:p>${cleaned}</a:p>`;
  });
}

(async () => {
  const JSZip = require(require.resolve('jszip', { paths: [path.dirname(require.resolve('pptxgenjs'))] }));
  const buffer = await pres.write({ outputType: 'nodebuffer' });
  const zip = await JSZip.loadAsync(buffer);
  for (const name of Object.keys(zip.files).filter((n) => /^ppt\/slides\/slide\d+\.xml$/.test(n))) {
    zip.file(name, cleanParagraphs(await zip.file(name).async('string')));
  }
  fs.mkdirSync(path.dirname(output), { recursive: true });
  fs.writeFileSync(output, await zip.generateAsync({ type: 'nodebuffer', compression: 'DEFLATE' }));
  console.log(`${output} (${slides.length} slides)`);
})();
