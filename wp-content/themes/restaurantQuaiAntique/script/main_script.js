"use strict";
const sPage = 'admin-ajax.php';
window.addEventListener('load', function(){

    //*** MENU - GESTION
    //Supression des menus
    let aBtnDeleteMenu = document.getElementsByClassName('btnDeleteMenu');
    for(const btn of aBtnDeleteMenu) {
        btn.addEventListener('click', function() {
            const idMenu = btn.closest('tr').getAttribute('data-id');
            //On créé une instance de l'objet menu pour utiliser le check dans les setters
            const oMenu = new Menu(idMenu);
            //Si il n'y a pas d'erreur dans la création de l'objet menu on poursuit
            if (oMenu.aError.length < 1) {
                const oMenuManager = new MenuManager();
                //On passe le menu au manager pour le delete de cette façon on s'assure que les data transmisent correspondent aux exigences de la bdd
                oMenuManager.delete(oMenu);
            }else {
                //Si une erreur de paramètre est trouvée on arrête le script et on avertit l'utilisateur par un alert
                alert(oMenu.aError);
                return false;
            }
        });
    }

    //Modification des menus
    let aInpTitleMenu = document.getElementsByClassName('inpTitleMenuUpdate');
    for(const inp of aInpTitleMenu){
        inp.addEventListener('keyup', function(){
            const idMenu = inp.closest('tr').getAttribute('data-id');
            const sTitle = inp.value;
            if(sTitle.length > 2) {
                const oMenu = new Menu(idMenu, sTitle);
                if (oMenu.aError.length < 1) {
                    const oMenuManager = new MenuManager();
                    oMenuManager.update(oMenu);
                } else {
                    alert(oMenu.aError);
                    return false;
                }
            }
        });
    }
    //*** FIN MENU - GESTION


    //*** ONGLET (TAB) DU BACKOFFICE
    const aTab = document.getElementsByClassName('tabBackOffice');
    for(const oTab of aTab)
    {
        oTab.addEventListener('click', function(){
            const idTab = oTab.getAttribute('data-id_tab');
            const oTabBackOffice = new TabBackOffice(idTab);
            const oTabManager = new TabBackOfficeManager();
            oTabManager.switchTab(oTabBackOffice);
        });
    }
    //*** FIN ONGLET (TAB) DU BACKOFFICE

});

class TabBackOfficeManager
{
    getAllTab()
    {
        return document.getElementsByClassName('tabBackOffice');
    }

    setDefaultAllTab()
    {
        const aTab = this.getAllTab();
        for(const oTab of aTab)
        {
            oTab.classList.remove('active');
        }
    }

    getAllContent()
    {
        return  document.getElementsByClassName('backOfficeSection');
    }

    hideAllContent()
    {
        const aContent = this.getAllContent();
        for(const oContent of aContent)
        {
            oContent.classList.add('hide');
        }
    }

    /**
     * @param oTab TabBackOffice
     * @var o HTMLElement
     */
    switchTab(oTab)
    {
        this.setDefaultAllTab();
        let o = oTab.getTabHtmlElement();
        o.classList.add('active');

        this.hideAllContent()
        let oContent = oTab.getContentHtmlElement();
        oContent.classList.remove('hide');
    }
}

class TabBackOffice
{
    constructor(idTab) {
        this.aError = [];
        this.setIdTab(idTab);
    }

    setIdTab(idTab)
    {
        try{ new ParamStrCheck(idTab, 'TabBackOffice idTab').checkMinLen(3).checkMaxLen(20); }
        catch (e){
            console.error(e.message);
            console.trace();
            this.aError.push(e.message);
        }
        this.idTab = idTab;
    }

    getTabHtmlElement()
    {
        const oTab = document.querySelector('.tabBackOffice[data-id_tab="' + this.idTab + '"]');
        try{ new ParamObjCheck(oTab, 'TabBackOffice oTab');}
        catch (e){
            console.error(e.message);
            console.trace();
            alert(e.message);
            return false;
        }
        return oTab;
    }

    getContentHtmlElement()
    {
        const oContent = document.querySelector('.backOfficeSection[data-id_tab="' + this.idTab + '"]');
        try{ new ParamObjCheck(oContent, 'TabBackOffice oContent');}
        catch (e){
            console.error(e.message);
            console.trace();
            alert(e.message);
            return false;
        }
        return oContent;
    }
}


class MenuManager
{
    getNonce()
    {
        let sNonce = document.getElementById('nc_ajax').value;
        try{ new ParamStrCheck(sNonce, 'sNonce').checkMinLen(1); }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
        return sNonce;
    }

    delete(oMenu)
    {
        //headers ??
        //const oHeader = new Headers();
        const sBody = new URLSearchParams({
            id: oMenu.id,
            action: 'switch_ajax',
            nonce: this.getNonce(),
            ajax: 'deleteMenu'});

        const oInit = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache' },
            body: sBody
        }

        fetch(sPage, oInit)
            .then((oResp) => {
                if(oResp.ok){ return oResp.json(); }
                else{
                    alert('Error then promise delete menu');
                    console.error('Error promise then delete menu');
                    console.trace();
                }
            })
            .then((oResp) => {
                console.log(oResp);
                if(oResp.data.code == 1) {
                    document.querySelector('tr[data-id="' + oMenu.id + '"]').remove();
                }
                else {
                    console.log(oResp.data.mess);
                    alert(oResp.data.mess);
                    console.trace();
                }
            })
            .catch((oResp) => {
                alert('Error catch promise delete menu');
                console.error(oResp);
                console.trace();
            });
     }

    update(oMenu)
    {
        const sBody = new URLSearchParams({
            id: oMenu.id,
            title: oMenu.title,
            action: 'switch_ajax',
            nonce: this.getNonce(),
            ajax: 'updateMenu'});

        const oInit = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache' },
            body: sBody
        }

        fetch(sPage, oInit)
            .then((oResp) => {
                if(oResp.ok){ return oResp.json(); }
                else{
                    alert('Error then promise update menu');
                    console.error('Error promise then update menu');
                    console.trace();
                }
            })
            .then((oResp) => {
                console.log(oResp);
                if(oResp.data.code == 1) {

                }
                else {
                    console.log(oResp.data.mess);
                    alert(oResp.data.mess);
                    console.trace();
                }
            })
            .catch((oResp) => {
                alert('Error catch promise');
                console.error(oResp);
                console.trace();
            });

    }


}

class Menu
{
    constructor(id, sTitle='') {
        this.aError = [];
        this.setIdMenu(id);
        if(sTitle !== '') this.setTitle(sTitle);
    }

    setIdMenu(id)
    {
        id = parseInt(id);
        try{ new ParamIntCheck(id, 'id menu').checkMin(1); }
        catch (e){
            console.error(e.message);
            console.trace();
            this.aError.push(e.message);
        }
        this.id = id;
    }

    setTitle(sTitle)
    {
        try{ new ParamStrCheck(sTitle, 'title menu').checkMinLen(3).checkMaxLen(50); }
        catch (e){
            console.error(e.message);
            console.trace();
            this.aError.push(e.message);
        }
        this.title = sTitle;
    }
}
