"use strict";
const sPage = 'admin-ajax.php';//Fonctionnement par défaut de wordpress il renvoi vers wp-admin/admin-ajax.php
const action = 'root_ajax';

window.addEventListener('load', function(){

    //*** MENU - GESTION
    //Modification des menus
    const aInpTitleMenu = document.getElementsByClassName('inpTitleMenuUpdate');
    for(const inp of aInpTitleMenu){
        inp.addEventListener('blur', function(){
            const idMenu = inp.closest('tr').getAttribute('data-id');
            const sTitle = inp.value;
            const oMenu = new Menu();
            oMenu.setId(idMenu).setTitle(sTitle);
            if(oMenu.aError.length > 0) {
                console.error(oMenu.aError);
                alert(oMenu.aError);
                return false;
            }
            const oMenuManager = new MenuManager(oMenu);
            oMenuManager.update();

        });
    }
    //*** FIN MENU - GESTION

    //*** OPTION MENU - GESTION
    //Update option menu => menu
    const aSelMenu = document.getElementsByClassName('selIdMenuUpMenuOption');
    for(const oSel of aSelMenu)
    {
        oSel.addEventListener('change', function(){
            const idOptionMenu = oSel.closest('tr').getAttribute('data-id');
            const idMenu = oSel.value;
            const sField = 'idMenu';
            const oManager = new OptionMenuManager();
            oManager.update(idOptionMenu, sField, idMenu);
        });
    }
    //Update option menu => title
    const aInpTitleOption = document.getElementsByClassName('inpTitleUpMenuOption');
    for(const oInp of aInpTitleOption)
    {
        oInp.addEventListener('blur', function(){
            const idOptionMenu = oInp.closest('tr').getAttribute('data-id');
            const sTitle = oInp.value;
            const sField = 'title';
            const oManager = new OptionMenuManager();
            oManager.update(idOptionMenu, sField, sTitle);
        });
    }
    //Update option menu => description
    const aTxtDescOption = document.getElementsByClassName('txtDescUpMenuOption');
    for(const oTxt of aTxtDescOption)
    {
        oTxt.addEventListener('blur', function(){
            const idOptionMenu = oTxt.closest('tr').getAttribute('data-id');
            const sDesc = oTxt.value;
            const sField = 'description';
            const oManager = new OptionMenuManager();
            oManager.update(idOptionMenu, sField, sDesc);
        });
    }
    //Update option menu => price
    const aInpPriceOption = document.getElementsByClassName('inpPriceUpMenuOption');
    for(const oInp of aInpPriceOption)
    {
        oInp.addEventListener('blur', function(){
            const idOptionMenu = oInp.closest('tr').getAttribute('data-id');
            const sPrice = oInp.value;
            const sField = 'price';
            const oManager = new OptionMenuManager();
            oManager.update(idOptionMenu, sField, sPrice);
        });
    }



    //*** DISH TYPE
    //Modification des types de plats
    const aInpTitleDishType = document.getElementsByClassName('inpTitleDishTypeUpdate');
    for(const inp of aInpTitleDishType){
        inp.addEventListener('blur', function(){
            const idDishType = inp.closest('tr').getAttribute('data-id');
            const sTitle = inp.value;
            const oDishTypeManager = new DishTypeManager();
            oDishTypeManager.update(idDishType, sTitle);
        });
    }
    //*** FIN DISH TYPE


    //*** FOOD DISH UPDATE
    //Update food dish => dish type
    const aSelDishType = document.getElementsByClassName('selIdDishTypeUpFoodDish');
    for(const oSel of aSelDishType)
    {
        oSel.addEventListener('change', function(){
            const idFoodDish = oSel.closest('tr').getAttribute('data-id');
            const idDishType = oSel.value;
            const sField = 'idDishType';
            const oManager = new FoodDishManager();
            oManager.update(idFoodDish, sField, idDishType);
        });
    }
    //Update food dish => title
    const aInpTitleFoodDish = document.getElementsByClassName('inpTitleUpFoodDish');
    for(const oInp of aInpTitleFoodDish)
    {
        oInp.addEventListener('blur', function(){
            const idFoodDish = oInp.closest('tr').getAttribute('data-id');
            const sTitle = oInp.value;
            const sField = 'title';
            const oManager = new FoodDishManager();
            oManager.update(idFoodDish, sField, sTitle);
        });
    }
    //Update food dish => description
    const aTxtDescFoodDish = document.getElementsByClassName('txtDescUpFoodDish');
    for(const oTxt of aTxtDescFoodDish)
    {
        oTxt.addEventListener('blur', function(){
            const idFoodDish = oTxt.closest('tr').getAttribute('data-id');
            const sDesc = oTxt.value;
            const sField = 'description';
            const oManager = new FoodDishManager();
            oManager.update(idFoodDish, sField, sDesc);
        });
    }
    //Update food dish => price
    const aInpPriceFoodDish = document.getElementsByClassName('inpPriceUpFoodDish');
    for(const oInp of aInpPriceFoodDish)
    {
        oInp.addEventListener('blur', function(){
            const idFoodDish = oInp.closest('tr').getAttribute('data-id');
            const sPrice = oInp.value;
            const sField = 'price';
            const oManager = new FoodDishManager();
            oManager.update(idFoodDish, sField, sPrice);
        });
    }

    //*** OPNENING TIME
    //Modifer les horaires d'ouverture
    const aBtnTimeDay   = document.getElementsByClassName('btnSaveTimeDay');
    for(const btn of aBtnTimeDay){
        btn.addEventListener('click', function(){
            const idOpening = btn.closest('tr').getAttribute('data-id');
            const sTimeStart = document.querySelector('tr[data-id="'+ idOpening + '"] .inpTimeDay[data-moment="start"]').value;
            const sTimeEnd = document.querySelector('tr[data-id="'+ idOpening + '"] .inpTimeDay[data-moment="end"]').value;
            if(sTimeStart === '' | sTimeEnd === ''){
                const sMess = 'Merci de saisir les deux plages horaires, heure et seconde.';
                new ToastAlert(ToastAlert.WARNING, sMess);

            }else{
                const oOpeningTimeManager = new OpeningTimeManager();
                oOpeningTimeManager.update(idOpening, sTimeStart, sTimeEnd);
            }
        });
    }

    //*** OPNENING TIME
    //Effacer les horaires d'ouverture
    const aBtnSaveTimeDay  = document.getElementsByClassName('btnEraseTimeDay');
    if(aBtnSaveTimeDay){
        for(const btn of aBtnSaveTimeDay){
            btn.addEventListener('click', function(){
                const idOpening = btn.closest('tr').getAttribute('data-id');
                const sTimeStart = '';
                const sTimeEnd = '';
                const oOpeningTimeManager = new OpeningTimeManager();
                oOpeningTimeManager.update(idOpening, sTimeStart, sTimeEnd, true);
            });
        }
    }

    //**TOOLS TOAST ALERT
    const boxToastAlert = document.getElementById(ToastAlert.CLASS_BOX_TOAST_ALERT);
    if(boxToastAlert){
        boxToastAlert.addEventListener('click', function (e) {
            e.target.closest('.' + ToastAlert.CLASS_CTN_TOAST_ALERT).remove();
        });
    }


    //GALLERY
    //Show gallery
    const aBtnChooseImgGal = document.querySelectorAll('.btnImgChoice');
    if(aBtnChooseImgGal){
        for(const btn of aBtnChooseImgGal){
            const oGallery = new Gallery();
            btn.addEventListener('click', function(){
                const idGallery = parseInt(btn.closest('tr').getAttribute('data-id_img_gallery'));
                try{
                    new ParamIntCheck(idGallery, 'idGallery').checkMin(0).checkMax(6);
                    oGallery.setIdItemGallery(idGallery);
                    oGallery.showOverlay();
                    oGallery.showWrapper();
                }
                catch (e){
                    alert(e.message);
                    console.error(e.message);
                    console.trace();
                    return false;
                }
            });
        }
    }

    //Quit gallery
    const oOverlay = document.getElementById('overlayGallery');
    if(oOverlay){
        oOverlay.addEventListener('click', function () {
            oOverlay.classList.add('hide');
            const oWrap = document.getElementById('imgChoiceWrapper');
            oWrap.setAttribute('data-id_item_gallery', '');
            oWrap.classList.add('hide');
        })
    }

    //Update img gallery
    const aCtnImgChoice = document.querySelectorAll('.ctnItemImgChoice');
    if(aCtnImgChoice){
        const oGallery = new Gallery;
        for(const oCtnImg of aCtnImgChoice){
            oCtnImg.addEventListener('click', function () {
                const idAttachment = parseInt(oCtnImg.getAttribute('data-id_attachment'));
                const sSrc = oCtnImg.querySelector('img').getAttribute('src');
                try{
                    new ParamIntCheck(idAttachment, 'idAttachment').checkMin(1);
                    oGallery.update(oGallery.getIdItemGallery(), idAttachment, 'idAttachment', sSrc);
                }
                catch (e){
                    alert(e.message);
                    console.error(e.message);
                    console.trace();
                    return false;
                }
            });
        }
    }

    //Update title img gallery
    const aTextarea = document.querySelectorAll('tr[data-id_img_gallery] textarea');
    if(aTextarea)
    {
        const oGallery = new Gallery;
        for(const oTxt of aTextarea)
        {
            oTxt.addEventListener('blur', function () {
                const idGallery = parseInt(oTxt.closest('tr').getAttribute('data-id_img_gallery'));
                const sTitle = oTxt.value;
                try{
                    new ParamStrCheck(sTitle, 'sTitle').checkMinLen(1);
                    oGallery.update(idGallery, sTitle, 'title');
                } catch (e){
                    alert(e.message);
                    console.error(e.message);
                    console.trace();
                    return false;
                }
            });
        }
    }

    //FIN GALLERY
});


class Manager
{
    getNonce()
    {
        let sNonce = document.getElementById('nc_ajax').value;
        try{
            new ParamStrCheck(sNonce, 'sNonce').checkMinLen(1);
            return sNonce;
        }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }

    }
}


class Gallery extends Manager
{
    getOverlay()
    {
        return document.getElementById('overlayGallery');
    }
    showOverlay()
    {
        const o = this.getOverlay();
        o.classList.remove('hide');
    }
    hideOverlay()
    {
        const o = this.getOverlay();
        o.classList.add('hide');
    }


    getIdItemGallery()
    {
        const oWrap = this.getHtmlElementWrapper();
        const idGallery = parseInt(oWrap.getAttribute('data-id_item_gallery'));

        try{ new ParamIntCheck(idGallery, 'idGallery').checkMin(0).checkMax(6); }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
        return idGallery;
    }
    setIdItemGallery(idGallery)
    {
        try{
            new ParamIntCheck(idGallery, 'idGallery').checkMin(0).checkMax(6);
            const oWrap = this.getHtmlElementWrapper();
            oWrap.setAttribute('data-id_item_gallery', idGallery);
        }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
    }

    getHtmlElementWrapper()
    {
        const oWrap = document.getElementById('imgChoiceWrapper');
        try{
            new ParamObjCheck(oWrap, 'oWrap');
            return oWrap;
        }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
    }
    showWrapper()
    {
        const oWrap = this.getHtmlElementWrapper();
        oWrap.classList.remove('hide');
    }
    hideWrapper()
    {
        const oWrap = this.getHtmlElementWrapper();
        oWrap.classList.add('hide');
    }

    setImgChoosed(idGalleryItem, sSrcImg)
    {
        const oImg = document.querySelector('tr[data-id_img_gallery="' + idGalleryItem + '"] .ctnImgChoice img');
        oImg.setAttribute('src', sSrcImg);
    }

    update(idGallery, value, sField, sSrcImg='')
    {
        const sBody = new URLSearchParams({
            idGallery: idGallery,
            value: value,
            field : sField,
            action: action,
            nonce: this.getNonce(),
            ajax: 'updateImgGallery'});

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
                if(parseInt(oResp.data.code) === 1) {
                    new ToastAlert(ToastAlert.SUCCESS, oResp.data.mess);
                    this.setIdItemGallery(0);
                    this.hideOverlay();
                    this.hideWrapper();
                    if(sSrcImg !== '') this.setImgChoosed(idGallery, sSrcImg);
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


class OpeningTimeManager extends Manager
{
    eraseField(id)
    {
        document.querySelector('tr[data-id="'+ id + '"] .inpTimeDay[data-moment="start"]').value = '';
        document.querySelector('tr[data-id="'+ id + '"] .inpTimeDay[data-moment="end"]').value = '';
    }

    update(id, sTimeStart, sTimeEnd, bErase=false)
    {
        const sBody = new URLSearchParams({
            id: id,
            timeStart: sTimeStart,
            timeEnd: sTimeEnd,
            action: action,
            nonce: this.getNonce(),
            ajax: 'updateOpeningTime'});

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
                if(parseInt(oResp.data.code) === 1) {
                    new ToastAlert(ToastAlert.SUCCESS, oResp.data.mess);
                    if(bErase)
                    {
                        this.eraseField(id);
                    }
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

class FoodDishManager extends Manager
{

    update(id, sField, sValue)
    {
        const sBody = new URLSearchParams({
            id: id,
            field: sField,
            value: sValue,
            action: action,
            nonce: this.getNonce(),
            ajax: 'updateFoodDish'});

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
                if(parseInt(oResp.data.code) === 1) {
                    new ToastAlert(ToastAlert.SUCCESS, oResp.data.mess);
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

class DishTypeManager extends Manager
{

    majTitleDishTypeAdd(id, sTitle)
    {
        const oOption = document.querySelector('#selOptionDishType option[value="'+ id +'"]');
        try{ new ParamObjCheck(oOption, 'oOption'); }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
        oOption.innerHTML = sTitle;
    }

    majTitleDishTypeUpdate(id, sTitle)
    {
        const aOption = document.querySelectorAll('.selIdDishTypeUpFoodDish option[value="'+ id +'"]');
        try{ new ParamObjCheck(aOption[0], 'aOption[0]'); }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
        for(const oOption of aOption)
        {
            oOption.innerHTML = sTitle;
        }
    }

    update(id, sTitle)
    {
        const sBody = new URLSearchParams({
            id: id,
            title: sTitle,
            action: action,
            nonce: this.getNonce(),
            ajax: 'updateDishType'});

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
                if(parseInt(oResp.data.code) === 1) {
                    new ToastAlert(ToastAlert.SUCCESS, oResp.data.mess);
                    this.majTitleDishTypeAdd(id, sTitle);
                    this.majTitleDishTypeUpdate(id, sTitle);
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

class OptionMenuManager
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

    update(id, sField, sValue)
    {
        const sBody = new URLSearchParams({
            id: id,
            field: sField,
            value: sValue,
            action: action,
            nonce: this.getNonce(),
            ajax: 'updateOptionMenu'});

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
                if(parseInt(oResp.data.code) === 1) {
                    new ToastAlert(ToastAlert.SUCCESS, oResp.data.mess);
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

    majTitleMenuAdd(id, sTitle)
    {
        const oOption = document.querySelector('#selOptionMenu option[value="'+ id +'"]');
        try{ new ParamObjCheck(oOption, 'oOption'); }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
        oOption.innerHTML = sTitle;
    }

    majTitleMenuUpdate(id, sTitle)
    {
        const aOption = document.querySelectorAll('.selIdMenuUpMenuOption option[value="'+ id +'"]');
        try{ new ParamObjCheck(aOption[0], 'aOption[0]'); }
        catch (e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
        for(const oOption of aOption)
        {
            oOption.innerHTML = sTitle;
        }
    }


    constructor(oMenu)
    {
        this.aError = [];
        this.setObjMenu(oMenu);
    }

    setObjMenu(oMenu) { this.oMenu = oMenu; }

    update()
    {
        const sBody = new URLSearchParams({
            id: this.oMenu.id,
            title: this.oMenu.title,
            action: action,
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
                if(parseInt(oResp.data.code) === 1) {
                    new ToastAlert(ToastAlert.SUCCESS, oResp.data.mess);
                    this.majTitleMenuAdd(this.oMenu.id, this.oMenu.title);
                    this.majTitleMenuUpdate(this.oMenu.id, this.oMenu.title);
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
    constructor() {
        this.aError = [];
    }

    setId(id)
    {
        id = parseInt(id);
        try{ new ParamIntCheck(id, 'id menu').checkMin(1); }
        catch (e){
            console.error(e.message);
            console.trace();
            this.aError.push(e.message);
        }
        this.id = id;
        return this;
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
        return this;
    }
}
