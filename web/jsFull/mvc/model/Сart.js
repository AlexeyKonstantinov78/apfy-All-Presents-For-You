class Cart {
    constructor() {
        this.actionAdd = '/shop/cart/add';
        this.actionRemove = '/shop/cart/remove';
        this.actionDelete = '/shop/cart/delete';
        this.arrayItems = this.getAllItems();
        //this.responseData;
    }

    setCart(id, quant, callback){
        //console.log(this.actionDelete);
        var obj = this;
        $.post( quant == 0 ? this.actionRemove : this.actionAdd, {id: id, quantity: quant, thumb: 327}, function( data ) {
            callback(data);
        });
        // $.post( quant == 0 ? this.actionDelete : this.actionAdd, {id: id, quantity: quant, thumb: 327}, function( data ) {
        //     this.arrayItems[data.id] = data.quantity;
        //     this.responseData = data;
        // });
    }

    removeItem(id, callback){
        $.post( this.actionDelete, {id: id}, function( data ) {
            callback(data);
        });
    }

    getAllItems(){
        var arrayItems = [];
        $.each($("#items > section[data-id]"), function(k,v) { arrayItems.push($(v).data("id")) });
        return arrayItems;
    }

}