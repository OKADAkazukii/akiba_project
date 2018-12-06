    function test(text){
        var str=text.value;
        if(str.match(/[^0-9]/g)){
            alert (str.match(/[^0-9]/g)+'\n基本給は半角数値で入力して下さい');
            text.value="";
            return false;
        }
    }
