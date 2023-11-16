export class ImgConverter {
    
    constructor(){}

    get convertJpgToWebp(){
        const figImages = document.querySelectorAll('figure');
        figImages.forEach(figure => {

            // Vérification de l'extension
            let imgTag = figure.firstChild;
            let imgSrc = imgTag.getAttribute('src');
            let imgAlt = imgTag.getAttribute('alt');

            if (imgSrc != null) {
                // Création de la balise Picture
                const pictureElement = document.createElement('picture');
                figure.appendChild(pictureElement);

                // Conversion to WebP
                if (imgSrc.endsWith(".jpg")) {

                    // Ajout des sources WebP
                    const sourceWebpElement = document.createElement('source');
                    sourceWebpElement.srcset = imgSrc.replace(/\.jpg$/, '.webp');
                    sourceWebpElement.type = 'image/webp';
                    pictureElement.appendChild(sourceWebpElement);
                    
                    // Ajout des sources JPG
                    const sourceJpegElement = document.createElement('source');
                    sourceJpegElement.srcset = imgSrc;
                    sourceJpegElement.type = 'image/jpeg';
                    pictureElement.appendChild(sourceJpegElement);

                } else if(imgSrc.endsWith(".png")) {

                    // Ajout des sources WebP
                    const sourceWebpElement = document.createElement('source');
                    sourceWebpElement.srcset = imgSrc.replace(/\.png$/, '.webp');
                    sourceWebpElement.type = 'image/webp';
                    pictureElement.appendChild(sourceWebpElement);
                    
                    // Ajout des sources JPG
                    const sourcePngElement = document.createElement('source');
                    sourcePngElement.srcset = imgSrc;
                    sourcePngElement.type = 'image/png';
                    pictureElement.appendChild(sourcePngElement);
                } else {
                    return false;
                }
                    
                // Ajout du conteneur IMG
                const imgContainer = document.createElement('img');
                imgContainer.src = imgSrc;
                imgContainer.alt = imgAlt;
                pictureElement.appendChild(imgContainer);

                // Retrait de l'image de base
                imgTag.remove();
            }

            
        })
    }
}