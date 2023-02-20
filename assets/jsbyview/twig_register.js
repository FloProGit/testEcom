console.log('register');




function test_str() {
    var res;
    var str =
        document.getElementById("t1").value;
    if (str.match(/[a-z]/g) && str.match(
        /[A-Z]/g) && str.match(
        /[0-9]/g) && str.match(
        /[^a-zA-Z\d]/g) && str.length >= 8)
        res = "TRUE";
    else
        res = "FALSE";
    document.getElementById("t2").value = res;

}