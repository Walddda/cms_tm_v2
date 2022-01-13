const flightpath = {
    curviness: 1.25,
    autoRotate: true,
    values: [
        {x:100, y:-20},
        {x:300, y:10},
        {x:500, y:100},
        {x:750, y:-100},
        {x:350, y:-50},
        {x:600, y:100},
        {x:800, y:0},
        {x:window.innerWidth, y:-250}
    ]
}
function pageScroll() {
    window.scrollBy(0,50);
    if(document.documentElement.scrollTop  >= 6502){

    }else{
        scrolldelay = setTimeout('pageScroll()',7.5); 
    }
}

document.getElementById('scrollStart').addEventListener('click', pageScroll);

const tween = new TimelineLite();

tween.add(
    TweenLite.to('.paper-plane', 1, {
        bezier: flightpath,
        ease: Power1.easeInOut
    })
)

const controller = new ScrollMagic.Controller()

const scene = new ScrollMagic.Scene({
    triggerElement:'.animation',
    duration:5000,
    triggerHook: 0
})

.setTween(tween)
// .addIndicators()
.setPin('.animation')
.addTo(controller)

