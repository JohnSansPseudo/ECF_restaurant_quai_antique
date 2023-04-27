class ParamObjCheck extends ParamCheck
{
    static TYPE_OF = 'object';
    constructor(obj, sVar)
    {
        super(obj, sVar);
        this.bIsTypeOf = this.checkIsTypeOf(ParamObjCheck.TYPE_OF);

    }

    checkDomElementById(sId)
    {
        if(sId !== this.val.id) {
            throw new Error(`Error id Element : ${this.val.id} is different to ${sId}`);
        }
        return this;
    }

    checkLength()
    {
        /*console.log(this.val);
        console.log(this.val.attributes);*/
        /* console.log(Object.keys(this.val));
        console.log(Object.values(this.val));
        console.log(Object.entries(this.val));*/


        //console.log(typeof o);
        //console.log(o.constructor);
        //if(Object.values(this.val).length === 0) this.aErr.push(`Error object "${this.sVar}" is empty`);
    }


}