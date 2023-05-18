class ParamIntCheck extends ParamCheck
{
    static TYPE_OF = 'number';
    constructor(iInt, sVar) {
        super(iInt, sVar);
        this.checkIsNan();
        this.bIsTypeOf = this.checkIsTypeOf(ParamIntCheck.TYPE_OF);
        this.checkIsTypeOf()
    }

    checkIsNan()
    {
        if(isNaN(this.val)) {
            throw new Error(`Error ${this.sVar } : ${this.val } is not a number`);
        }
    }

    checkIsTypeOf()
    {
        if(!Number.isInteger(this.val)) {
            throw new Error(`Error ${this.sVar } : ${this.val } is not an integer, typeOf ${this.sVar } : ${typeof this.val}`);
        }
    }

    checkMin(iMin)
    {
        if(this.val < iMin){
            throw new Error(`Error ${this.sVar} < iMin , ${this.val} < ${iMin}`);
        }
        return this;

    }

    checkMax(iMax)
    {
        if(this.val > iMax) {
            throw new Error(`Error ${this.sVar} > iMax , ${this.val} > ${iMax}`);
        }
        return this;
    }
}