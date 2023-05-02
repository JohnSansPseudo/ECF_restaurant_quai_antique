class ToastAlert
{
    //READ FIRST
    //YOU HAVE TO SET '<div id="boxCtnToast"></div>' in your html
    //You have to set CSS boxCtnToast as you wish

    //SET THE EVENT IN YOUR MAIN SCRIPT
    /*document.getElementById(ToastAlert.CLASS_BOX_TOAST_ALERT).addEventListener('click', function (e) {
        e.target.closest('.' + ToastAlert.CLASS_CTN_TOAST_ALERT).remove();
    });*/

    static INFO = 'info';
    static SUCCESS = 'success';
    static WARNING = 'warning';
    static DANGER = 'danger';
    static CLASS_CTN_TOAST_ALERT = 'ctnToaster';
    static CLASS_BOX_TOAST_ALERT = 'boxCtnToast';

    constructor(sType, sMess, iTimeDisplay=2500, sTitle='')
    {
        this.title = 'DEFAULT';
        if(sTitle !== '') this.setTitle(sTitle);
        this.htmlToaster = '';
        this.sClassTypeToast = '';
        this.oBoxCtnToaster = document.getElementById(ToastAlert.CLASS_BOX_TOAST_ALERT);
        this.setMessage(sMess);
        this.switchTypeAlert(sType);
        this.oBoxCtnToaster.prepend(this.createHtmlToaster());
        setTimeout(this.toastDisappear, iTimeDisplay);
    }

    emptyBoxCtnToast()
    {
        /*document.querySelectorAll(ToastAlert.CLASS_CTN_TOASTER).forEach(function(el){
            el.remove();
        })*/
    }

    setMessage(sMess)
    {
        try{ new ParamStrCheck(sMess, 'sMess').checkMinLen(3).checkMaxLen(500);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        this.sMess = sMess;
        return this;
    }

    getMessage()
    {
        try{ new ParamStrCheck(this.sMess, 'this.sMess').checkMinLen(3).checkMaxLen(500);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        return this.sMess;
    }

    setTitle(sTitle)
    {
        try{ new ParamStrCheck(sTitle, 'sTitle').checkMinLen(3).checkMaxLen(50);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        this.title = sTitle;
        return this;
    }

    getTitle()
    {
        try{ new ParamStrCheck(this.title, 'this.title').checkMinLen(3).checkMaxLen(50);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        return this.title;
    }

    setHtmlIcon(sHtml)
    {
        try{ new ParamStrCheck(sHtml, 'sHtml').checkMinLen(3).checkMaxLen(500);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        this.sHtmlIcon = sHtml
        return this;
    }

    getHtmlIcon()
    {
        try{new ParamStrCheck(this.sHtmlIcon, 'this.sHtmlIcon').checkMinLen(3).checkMaxLen(500);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        return this.sHtmlIcon;
    }

    getClassTypeToast()
    {
        try{new ParamStrCheck(this.sClassTypeToast, 'this.sClassTypeToast').checkMinLen(3).checkMaxLen(20);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        return this.sClassTypeToast;
    }

    setClassTypeToast(sClassTypeToast)
    {
        try{new ParamStrCheck(sClassTypeToast, 'sClassTypeToast').checkMinLen(3).checkMaxLen(20);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }
        this.sClassTypeToast = sClassTypeToast
        return this;
    }

    switchTypeAlert(sType)
    {
        try{new ParamStrCheck(sType, 'sType').checkMinLen(3).checkMaxLen(20);}
        catch(oErr){
            alert(oErr.message);
            console.log(oErr.message);
            console.trace();
            return false;
        }

        let sHtmlIco = '';
        let sClassToast = '';
        let sTitle = '';
        switch(sType)
        {
            case ToastAlert.INFO:
                sHtmlIco = '<i class="fa-solid fa-circle-info"></i>';
                sClassToast = 'infoToast';
                sTitle = 'INFO';
                break;
            case ToastAlert.SUCCESS:
                sHtmlIco = '<i class="fa-solid fa-circle-check"></i>';
                sClassToast = 'successToast';
                sTitle = 'SUCCESS';
                break;
            case ToastAlert.WARNING:
                sHtmlIco = '<i class="fa-solid fa-triangle-exclamation"></i>';
                sClassToast = 'warningToast';
                sTitle = 'WARNING';
                break
            case ToastAlert.DANGER:
                sHtmlIco = '<i class="fa-solid fa-skull-crossbones"></i>';
                sClassToast = 'dangerToast'
                sTitle = 'ERROR';
                break;
            default:
                sHtmlIco = '<i class="fa-regular fa-face-meh"></i>';
                sClassToast = '';
                sTitle = 'DEFAULT ??';
        }
        this.setHtmlIcon(sHtmlIco);
        this.setClassTypeToast(sClassToast);
        if(this.getTitle() === 'DEFAULT') this.setTitle(sTitle);
    }

    createHtmlToaster()
    {
        let el = document.createElement('div');
        el.classList.add(this.getClassTypeToast(), ToastAlert.CLASS_CTN_TOAST_ALERT);
        el.innerHTML = '<div class="head">' + this.getHtmlIcon() + '<span>' + this.getTitle() + '</span></psan></div><div class="body">' + this.getMessage() + '</div>';
        return el;
    }

    toastDisappear()
    {
        let el = document.getElementsByClassName(ToastAlert.CLASS_CTN_TOAST_ALERT);
        if(el.length > 0)
        {
            let iLastItem = el.item.length - 1;
            el.item(iLastItem).remove();
        }
    }

}