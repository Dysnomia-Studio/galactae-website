var iconSelect;
var selectedText;

window.addEventListener("load", function(){
    
    // Variables de base
    selectedText = document.getElementById('selected-language');
    languageForm = document.getElementById('language-form');
    changed = 0;
    
    // Evenement du changement de drapeau
    document.getElementById('language-list').addEventListener('changed', function(e){
       selectedText.value = iconSelect.getSelectedValue();
       changed++;
       if(changed==2) { // Car sinon il s'envoie dès le chargement de la page
           languageForm.submit();
       }
    });
    
    // Chargement de la liste des drapeaux
    iconSelect = new IconSelect("language-list");

    var icons = [];
    icons.push({'iconFilePath':'img/flags/fr.png', 'iconValue':'fr'});
    icons.push({'iconFilePath':'img/flags/en.png', 'iconValue':'en'});
    icons.push({'iconFilePath':'img/flags/ru.png', 'iconValue':'ru'});
    icons.push({'iconFilePath':'img/flags/de.png', 'iconValue':'de'});
    
    iconSelect.refresh(icons);
});