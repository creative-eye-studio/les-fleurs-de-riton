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
            // renderByPixels: true,
            // continuousScrolling: true,
            delegateTo: document,
            thumbMinSize: 15
        });

        scrollbar.track.xAxis.element.remove();

        AOS.init({
            duration: 1000,
            delay: 200,
            disable: 'mobile',
        });

        const elements = document.querySelectorAll('[data-aos]');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                } else {
                    entry.target.classList.remove('aos-animate');
                }
            });
        }, { threshold: 0.5 }); // Adjust the threshold as needed

        elements.forEach(el => {
            observer.observe(el);
        });

        // Détection du Scroll
        scrollbar.addListener(() => {
            const scrollY = scrollbar.offset.y;
            const htmlElement = document.querySelector('html');
            htmlElement.classList.toggle('onScroll', scrollY > 50);
        });
        
        
        // Scroll au click d'une ancre
        const navLinks = document.querySelectorAll('a[href^="#"]');
        navLinks.forEach(btn => {
            btn.addEventListener('click', function(){
                const margin = 100;
                const target = btn.getAttribute('href') || btn.getAttribute('data-link');
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