
let _values = null;
export class User {
    static get instance() {
        return _values ? _values : _values = new User();
    }
    constructor() {
        this._value = {};
    }
    get value() {
        return this._value;
    }
    set(value) {
        this._value = value;
    }

    edit(prop, value) {
        this._value[prop] = value;
    }


}