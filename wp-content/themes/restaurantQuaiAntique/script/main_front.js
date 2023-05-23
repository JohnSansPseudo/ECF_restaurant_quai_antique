"use strict";
const action = 'root-ajax';
window.addEventListener('load', function() {

    $.fn.datepicker.dates['fr'] = {
        days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vandredi", "Samedi"],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        daysMin: ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
        months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Decembre"],
        monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Jun", "Jui", "Aoû", "Sep", "Oct", "Nov", "Dec"],
        today: "Aujourd'hui",
        clear: "Effacer",
        format: "dd/mm/yyyy",
        titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
        weekStart: 1
    };

    $('.datepicker').datepicker({
        daysOfWeekDisabled: "7",
        autoclose: true,
        orientation: 'left bottom',
        language: 'fr'

    });

    $('#inpDateBook').on('change', function(){
        //Modfication des horaires proposé en fonction du jour sélectionné
        const sFrDate = $(this).val();
        try{ new ParamStrCheck(sFrDate, 'sFrDate').checkMinLen(10).checkMaxLen(10); }
        catch(e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
        try{
            const sSqlDate = DateJs.sDateToSql(sFrDate, '/', DateJs.FR_LANG);
            const oBookingHoursDay = new BookingHoursDay();
            const sPage = $(this).attr('data-action');//Voir page book-table
            oBookingHoursDay.updateBookingHours(sSqlDate, sPage);
        }
        catch(e){
            alert(e.message);
            console.error(e.message);
            console.trace();
            return false;
        }
    });

    //PAGE RESERVATION
    //Gestion des boutons de sélection d'heure pour les réservations
    const oCtnHourBooking = document.getElementById('ctnHourBooking');
    if(oCtnHourBooking){
        oCtnHourBooking.addEventListener('click', function(e){
            if(e.target.classList.contains('btnHour') && !e.target.classList.contains('disabled')){
                const oManagerHour = new BtnHourManager();
                oManagerHour.switchSelectedHour(e.target);
            }
        });
    }

    //Connexion client & admin
    const oBtnConn = document.getElementById('btnConn');
    if(oBtnConn){
        oBtnConn.addEventListener('click', function (e) {
            const bAdmin = document.getElementById('formUserConn').getAttribute('data-conn_admin');
            if(bAdmin === '1'){
                document.getElementById('formUserConn').setAttribute('data-conn_admin', '0');//reset de la valeur
            } else {
                document.getElementById('formUserConn').setAttribute('action', '#');
                e.preventDefault();
                document.querySelector('.errorForm').innerHtml = '';
                //sPageAjax
                const sPageAjax = document.getElementById('formUserConn').getAttribute('data-page_ajax');
                try{
                    new ParamStrCheck(sPageAjax, 'sPageAjax').checkMinLen(3).checkMaxLen(100);
                }
                catch(e){
                    alert('Error contact an admin');
                    console.error(e.message);
                    return false;
                }

                //sPageReload
                const sPageReload = document.getElementById('formUserConn').getAttribute('data-page_reload');
                try{
                    new ParamStrCheck(sPageReload, 'sPageReload').checkMinLen(3).checkMaxLen(100);
                }
                catch(e){
                    alert('Error contact an admin');
                    console.error(e.message);
                    return false;
                }

                //sPageAdminConn
                const sPageAdminConn = document.getElementById('formUserConn').getAttribute('data-page_admin_conn');
                try{
                    new ParamStrCheck(sPageAdminConn, 'sPageAdminConn').checkMinLen(3).checkMaxLen(100);
                }
                catch(e){
                    alert('Error contact an admin');
                    console.error(e.message);
                    return false;
                }

                //sMail
                const sMail = document.getElementById('user_login').value;
                try{
                    new ParamStrCheck(sMail, 'sMail').checkMinLen(3).checkMaxLen(50);
                    document.getElementById('user_login').parentNode.querySelector('.error').innerHtml = '';
                }
                catch(e){
                    sMail.parentNode.querySelector('.error').innerHtml = e.message;
                    return false;
                }

                //sPass
                const sPassword = document.getElementById('user_pass').value;
                try{
                    new ParamStrCheck(sPassword, 'sPassword').checkMinLen(3).checkMaxLen(50);
                    document.getElementById('user_pass').parentNode.querySelector('.error').innerHtml = '';
                }
                catch(e){
                    sPassword.parentNode.querySelector('.error').innerHtml = e.message;
                    return false;
                }

                const oUserConnexion = new UserConnexion();
                oUserConnexion.isClient(sMail, sPassword, sPageAjax, sPageReload, sPageAdminConn);
            }
        });
    }
    //FIN Connexion client & admin


    //TITLE GALLERY
    const aBlock = document.querySelectorAll('.ctnImgGallery');
    if(aBlock){
        for(let oBlock of aBlock) {
            oBlock.addEventListener('mouseenter', function () {
                oBlock.querySelector('.ctnTitleImgGallery').animate([
                    { opacity: 1}], { duration: 300, fill: "forwards"});
            });

            oBlock.addEventListener('mouseleave', function () {
                oBlock.querySelector('.ctnTitleImgGallery').animate([
                    { opacity: 0}], { duration: 300, fill: "forwards"});
            });
        }
    }
    //FIN TITLE GALLERY
});

class UserConnexion
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

    isClient(sMail, sPassword, sPageAjax, sPageReload, sPageAdminConn)
    {
        const sBody = new URLSearchParams({
            action: 'root_ajax',
            mail: sMail,
            password: sPassword,
            nonce: this.getNonce(),
            ajax: 'isClient'});

        const oInit = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache' },
            body: sBody
        }

        fetch(sPageAjax, oInit)
            .then((oResp) => {
                if(oResp.ok){ return oResp.json(); }
                else{
                    alert('Error then promise update menu');
                    console.error('Error promise then update menu');
                    console.trace();
                }
            })
            .then((oResp) => {

                if(parseInt(oResp.data.code) === 1) document.location.href = sPageReload;
                else this.isUserNameAdmin(sMail, sPassword, sPageAjax, sPageAdminConn);
            })
            .catch((oResp) => {
                alert('Error catch promise');
                console.error(oResp);
                console.trace();
            });
    }

    isUserNameAdmin(sMail, sPassword, sPageAjax, sPageAdminConn)
    {
        const sBody = new URLSearchParams({
            action: 'root_ajax',
            mail: sMail,
            nonce: this.getNonce(),
            ajax: 'isUserNameAdmin'});

        const oInit = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache' },
            body: sBody
        }

        fetch(sPageAjax, oInit)
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
                    document.getElementById('formUserConn').setAttribute('action', sPageAdminConn);
                    document.getElementById('formUserConn').setAttribute('data-conn_admin', '1');

                    const event = new MouseEvent('click', {
                        view: window,
                        bubbles: true,
                        cancelable: true
                    });
                    document.getElementById("btnConn").dispatchEvent(event);
                }else{
                    document.getElementById('formUserConn').setAttribute('action', '#');
                    document.getElementById('formUserConn').setAttribute('data-conn_admin', '0');
                    document.querySelector('.errorForm').innerHtml = 'Error any account with these identifiers';
                }
            })
            .catch((oResp) => {
                alert('Error catch promise');
                console.error(oResp);
                console.trace();
            });
    }
}

class BtnHourManager
{
    removeAllSelectedClass()
    {
        const aBtnHour = document.getElementsByClassName('btnHour');
        for(let oBtn of aBtnHour) {
            oBtn.classList.remove('selected');
        }
    }

    setSelectedClass(oBtnHour)
    {
        oBtnHour.classList.add('selected');
    }

    setInputRadio(oBtnHour)
    {
        let oInp = oBtnHour.parentNode.getElementsByClassName('inpBookingHour')[0];
        oInp.setAttribute('checked', 'checked');
    }

    switchSelectedHour(oBtnHour)
    {
        const o = document.querySelector('.inpBookingHour[checked=checked]');
        o.attributes.removeNamedItem('checked');
        this.removeAllSelectedClass();
        this.setSelectedClass(oBtnHour);
        this.setInputRadio(oBtnHour);

    }

}

class BookingHoursDay
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

    updateBookingHours(sSqlDay, sPage)
    {
        const sBody = new URLSearchParams({
            sqlDay: sSqlDay,
            action: 'root_ajax',
            nonce: this.getNonce(),
            ajax: 'updateBookingHours'});

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
                    //RESULT HTML
                    document.querySelector('#ctnHourBooking .sectionHourBooking[data-time="midi"] .body').innerHTML = oResp.data.comp.midi;
                    document.querySelector('#ctnHourBooking .sectionHourBooking[data-time="soir"] .body').innerHTML = oResp.data.comp.soir;
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