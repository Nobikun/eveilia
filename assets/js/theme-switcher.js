// Robust theme & font switcher: applies saved values immediately and updates controls
(function(){
  const ROOT = document.body || document.documentElement;

  function clearPrefix(prefix){
    Array.from(ROOT.classList).forEach(c => { if(c.startsWith(prefix)) ROOT.classList.remove(c); });
  }

  window.setTheme = function(name){
    clearPrefix('theme-');
    if(name && name !== 'default') ROOT.classList.add('theme-' + name);
    localStorage.setItem('eveilia-theme', name || 'default');
    // update select UI if present
    const sel = document.querySelector('.theme-controls select[name="theme-select"]');
    if(sel) sel.value = name || 'default';
  };

  window.setFont = function(name){
    clearPrefix('font-');
    if(name && name !== 'default') ROOT.classList.add('font-' + name);
    localStorage.setItem('eveilia-font', name || 'default');
    const sel = document.querySelector('.theme-controls select[name="font-select"]');
    if(sel) sel.value = name || 'default';
  };

  function restore(){
    const savedTheme = localStorage.getItem('eveilia-theme') || 'default';
    const savedFont  = localStorage.getItem('eveilia-font')  || 'default';
    // apply without waiting
    if(savedTheme && savedTheme !== 'default') ROOT.classList.add('theme-' + savedTheme);
    if(savedFont && savedFont !== 'default') ROOT.classList.add('font-' + savedFont);
    // sync selects
    const themeSel = document.querySelector('.theme-controls select[name="theme-select"]');
    const fontSel  = document.querySelector('.theme-controls select[name="font-select"]');
    if(themeSel) themeSel.value = savedTheme;
    if(fontSel)  fontSel.value = savedFont;
  }

  if(document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', restore);
  } else {
    restore();
  }
})();