class ParamCheck
{
    constructor(mVal, sVar)
    {
        if (this.constructor === ParamCheck) {
            throw new TypeError('Abstract class "ParamCheck" cannot be instantiated directly');
        }
        this.sVar = sVar;
        this.val = mVal;
        this.checkUndefined();
        this.checkIsNull();
    }

    checkUndefined()
    {
        if(this.val === undefined){
            throw new Error(`Error "${this.sVar}" is undefined`);
        }
    }

    checkIsNull()
    {
        if(this.val === null){
            throw new Error(`Error "${this.sVar}" is null`);
        }
    }

    checkIsTypeOf(sType)
    {
        let sTypeOf = typeof this.val;
        if(sTypeOf !== sType){
            throw new Error(`Error ${this.sVar } : ${this.val } is not type of ${sType}, typeOf ${this.sVar } : ${sTypeOf}`);
        }
    }
}