hs.graphicsDir = 'catalog/view/javascript/highslide/graphics/';

hs.lang = {
    cssDirection:     'ltr',
    loadingText :     'Ожидание...',
    loadingTitle :    'Нажмите, чтобы отменить',
    focusTitle :      'Нажмите, чтобы выдвинуть на',
    fullExpandTitle : 'Развернуть до исходного размера',
    fullExpandText :  'Полный экран',
    creditsText :     'Работает на Highslide JS',
    creditsTitle :    'Перейдите на главную страницу Highslide JS',
    previousText :    'Предыдущий',
    previousTitle :   'Предыдущие (стрелка влево)',
    nextText :        'Следующий',
    nextTitle :       'Дальше (стрелка вправо)',
    moveTitle :       'Двигаться',
    moveText :        'Двигаться',
    closeText :       'Закрывать',
    closeTitle :      'Закрыть (Esc)',
    resizeTitle :     'Размер восстановление',
    playText :        'Играть',
    playTitle :       'Воспроизвести слайд-шоу (пробел)',
    pauseText :       'Пауза',
    pauseTitle :      'Пауза слайд-шоу (пробел)',
    number :          'Изображение 1 2',
    restoreTitle :    'Нажмите, чтобы закрыть изображения, нажмите и удерживайте, чтобы перетащить. Используйте стрелки для движения вперед и назад.'
};

hs.addSlideshow({
    interval: 5000,
    repeat: false,
    useControls: true,
    fixedControls: true,
    overlayOptions: {
    opacity: .6,
    position: 'top center',
    hideOnMouseOut: true
    }
});

hs.transitions = ['expand', 'crossfade'];

if (typeof(_gat) == 'object') {
    var pageTracker = _gat._getTracker("");
    pageTracker._initData();
    pageTracker._trackPageview();
}