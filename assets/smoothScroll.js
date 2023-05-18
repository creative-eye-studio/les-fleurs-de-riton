import Scrollbar from 'smooth-scrollbar';

export class ScrollWeb {

    constructor(damping){
        this.damping = damping
    }

    get init(){
        const container = document.querySelector('#content');
        const header = document.querySelector('header');
        const scrollbar = Scrollbar.init(container, {
            damping: (this.damping / 100),
            renderByPixels: true,
            continuousScrolling: true,
            delegateTo: document,
            thumbMinSize: 15
            // alwaysShowTracks: true,
        });

        // Détection du Scroll
        scrollbar.addListener(function(){
            const scrollY = scrollbar.offset.y;
            if (scrollY > 50) {
                document.querySelector('html').classList.add('onScroll');
            } else {
                document.querySelector('html').classList.remove('onScroll');
            }
        })

        // Scroll au click d'une ancre
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(btn => {
            btn.addEventListener('click', function(){
                const target = btn.getAttribute('data-link');
                const anchor = document.querySelector(target);
                const offset = anchor.getBoundingClientRect().top - container.getBoundingClientRect().top;
                scrollbar.scrollIntoView(anchor, { offset });
                return false;
            })
        })

        return scrollbar;
    }
}