// ページがスクロールされるたびにスクロール位置を保存
window.addEventListener('scroll', function() {
    localStorage.setItem('scrollPosition', window.scrollY);
});

// ページ読み込み時にスクロール位置を復元
window.addEventListener('load', function() {
    const scrollPosition = localStorage.getItem('scrollPosition');
    if (scrollPosition) {
        window.scrollTo(0, parseInt(scrollPosition, 10));
    }
});
