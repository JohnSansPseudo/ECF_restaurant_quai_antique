class ParamStrCheck extends ParamCheck
{
    static TYPE_OF = 'string';
    constructor(sStr, sVar) {
        super(sStr, sVar);
        this.checkIsTypeOf(ParamStrCheck.TYPE_OF);
    }

    checkMaxLen(iMaxLength)
    {
        this.iMaxLength = parseInt(iMaxLength);
        if(this.val.length > this.iMaxLength) {
            throw new Error(`Error the entered value "${this.sVar}" is too long : ${this.val.length} > ${ this.iMaxLength }`);
        }
        return this;
    }

    checkMinLen(iMinLength)
    {
        this.iMinLength = parseInt(iMinLength);
        if(this.val.length < this.iMinLength) {
            throw new Error(`Error the entered value "${this.sVar}" is too short : ${this.val.length} < ${ this.iMinLength }`);
        }
        return this;
    }

}