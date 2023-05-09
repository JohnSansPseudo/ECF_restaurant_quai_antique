
class DateJs
{
    static FR_LANG = 'FR';
    static EN_LANG = 'EN';
    static US_LANG = 'US';
    static SLAHS_SEP = '/';
    static DASH_SEP = '-';

    /**
     *
     * @param oDate Date
     * @param sDateLang string
     * @returns Date
     */
    static oDateToStr(oDate, sDateLang)
    {
        let oIntl = null;
        switch(sDateLang)
        {
            case DateJs.FR_LANG:
                oIntl = new Intl.DateTimeFormat("fr-FR",
                    {
                        day:"2-digit",
                        month:"2-digit",
                        year:"numeric"
                    });
                break;

            case DateJs.US_LANG:
                oIntl = new Intl.DateTimeFormat("en-US",
                    {
                        day:"2-digit",
                        month:"2-digit",
                        year:"numeric"
                    });
                break;
            default:
                throw new Error('Unrecognized lang for getObjFormatDate');
        }
        return oIntl.format(oDate);
    }


    /**
     *
     * @param sDate string
     * @param sSeparator string
     * @param sDateLang string
     * @returns string
     */
    static sDateToSql(sDate, sSeparator, sDateLang)
    {
        let sDateSql = '';
        let aDate = sDate.split(sSeparator);
        switch(sDateLang)
        {
            case DateJs.FR_LANG:
                sDateSql = aDate[2] + '-' + aDate[1] + '-' + aDate[0];
                break;
            case DateJs.EN_LANG:
                sDateSql = aDate[2] + '-' + aDate[1] + '-' + aDate[0];
                break;
            case DateJs.US_LANG:
                sDateSql = aDate[2] + '-' + aDate[0] + '-' + aDate[1];
                break;
            default:
                throw new Error('Unrecognized lang for sDateToSql : ' + sDateLang);
        }
        return sDateSql;
    }

}
