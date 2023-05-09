"use strict";
//const sPage = 'admin-ajax.php';//Fonctionnement par défaut de wordpress il renvoi vers wp-admin/admin-ajax.php
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
    const oUserLogin = document.getElementById('user_login');
    if(oUserLogin){
        oUserLogin.addEventListener('blur', function(){
            const oUserConn = new UserConnexion();
            const sPage = this.getAttribute('data-action');//attributes.getNamedItem('data-action');
            try{ new ParamStrCheck(sPage, 'sPage').checkMinLen(3).checkMaxLen(50); }
            catch(e){
                alert(e.message);
                console.error(e.message);
                console.trace();
                return false;
            }
            const sMail = document.getElementById('user_login').value;
            try{ new ParamStrCheck(sMail, 'sMail').checkMinLen(3).checkMaxLen(50); }
            catch(e){
                alert(e.message);
                console.error(e.message);
                console.trace();
                return false;
            }
            oUserConn.isUserNameAdmin(sMail, sPage);
        });
    }
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

    isUserNameAdmin(sMail, sPage)
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
                    const sPath = "http://ecf_studi.localhost/wp-login.php";
                    document.getElementById('formUserConn').setAttribute('action', sPath);
                }else{
                    document.getElementById('formUserConn').setAttribute('action', '#');
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

    setInputsRadio(oBtnHour)
    {
        let oInp = oBtnHour.parentNode.getElementsByClassName('inpBookingHour')[0];
        oInp.checked = true;
        oInp = oBtnHour.parentNode.getElementsByClassName('inpIdOpening')[0];
        oInp.checked = true;
    }

    switchSelectedHour(oBtnHour)
    {
        this.removeAllSelectedClass();
        this.setSelectedClass(oBtnHour);
        this.setInputRadio(oBtnHour);

        const o = document.querySelector('.inpBookingHour[checked=checked]');
        console.log(o);
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