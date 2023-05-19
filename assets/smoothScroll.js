import Scrollbar from 'smooth-scrollbar';
import AOS from 'aos';

export class ScrollWeb {

    constructor(damping){
        this.damping = damping
    }

    get init(){
        const container = document.querySelector('#content');
        const scrollbar = Scrollbar.init(container, {
            damping: (this.damping / 100),
            renderByPixels: true,
            continuousScrolling: true,
            delegateTo: document,
            thumbMinSize: 15
        });

        scrollbar.track.xAxis.element.remove()

        // Animate on Scroll
        AOS.init({
            duration: 1000,
            delay: 200,
            disable: 'mobile',
        });
      
        [].forEach.call(document.querySelectorAll('[data-aos]'), (el) => {
          scrollbar.addListener(() => {
            if (scrollbar.isVisible(el)) {
              el.classList.add('aos-animate');
            } else {
              el.classList.remove('aos-animate');
            }
          });
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
                const margin = 100;
                const target = btn.getAttribute('data-link');
                const anchor = document.querySelector(target);
                const offset = container.getBoundingClientRect().top - anchor.getBoundingClientRect().top;
                scrollbar.scrollIntoView(anchor, { 
                    offset, 
                    offsetTop: margin
                });
                return false;
            })
        })
        
        return scrollbar;
    }
}