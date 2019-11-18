var  a = 10;
function  isNumber(value) {
    return typeof value === 'number' && isFinite(value);
}

console.log("a la number : "  + isNumber(a));
console.log('-------------------------------------');

var b = "dfdqw";
function isString (value) {
    return typeof value === 'string';
}

console.log("b la string : "  + isString(b));
console.log('-------------------------------------');

var c = ['a', 'b','c'];
function isArray (value) {
    return typeof value === 'object' && value.constructor === Array;
}
console.log("c la array : "  + isArray(c));
console.log('-------------------------------------');

var d = {
    name : 'Hoiz',
    email : 'hoiz@gmail.com',
};
function isObject (value) {
    return typeof value === 'object' && value.constructor === Object;
}
console.log("d la object : "  + isObject(d));
console.log('-------------------------------------');

function total(){
    var a = 5;
    var b = 6;
    return a + b;
}

function isFunction (value) {
    return typeof value === 'function';
}
console.log("Total la function: "  + isFunction(total));
console.log("isObject la function: "  + isFunction(isObject));
console.log('-------------------------------------');

var human = new Object;
human.firstName = 'Traan';
human.lastName = "Anh";
human.email = "gs.hoanganh@gmail.com";
console.log(human);
console.log('-------------------------------------');

var student = {
    name : 'Tran Anh',
    'email' : 'gs.hoanganh@gmail.com',
};
console.log(student);
console.log('-------------------------------------');

function Human(firstName,lastName, email, gender){
    this.firstName = firstName;
    this.lastName = lastName;
    this.gender = gender;
    this.fullName = function(){
        return this.firstName + "" + this.lastName;
    }
}

var human_1 = new Human('Long','Nguyen' ,'longnguyen@gmail.com','male');
var human_2 = new Human('Huyen','Tran' ,'huyentr@gmail.com','female');
console.log(human_1);
console.log(human_2);
console.log('-------------------------------------');

var arr = ["Học", "lập", "trình", "tại", "freetuts.net"];
console.log(arr);

console.log('----------------array.push()---------------------');
// Them 1 ptu vao mang
$text = 'Free';
arr.push($text);
console.log(arr);

console.log('-------------array.pop()------------------------');
//xoa 1 ptu cuoi cung cua mang
arr.pop();
console.log(arr);

console.log('-------------array.shift()------------------------');
// xoa 1 ptu dau tien cua mang , don cac ptu phia sau xuong 1 bac
arr.shift();
console.log(arr);

console.log('-------------array.unshift()------------------------');
// them 1 ptu vao vi tri dau cua mang , day cac ptu phia sau len 1 bac
var text = "I and You";
arr.unshift(text);
console.log(arr);

console.log('-------------array.splice ()------------------------');
// array.splice(position_add, num_element_remove, value1, value2, ...)
/*@param : position_add  : vị trí sẽ thêm
/*@param : num_element_remove : số phần tử sẽ xóa
/*@param : value1,value2 ... danh sách các phần tử sẽ được thêm vào sau khi tại vị trí position_add và sau khi remove num_element_remove phần tử.
 */

var position_add = 3;
var num_element_remove = 3;
var value1 = "Laravel";
var value2 = "C#";
arr.splice(position_add, num_element_remove, value1,value2);
console.log(arr);

console.log('-------------array.sort ()------------------------');
// sap xep mang theo bang chu cai alpha
arr.sort();
console.log(arr);

console.log('-------------array.reverse ()------------------------');
// Dao nguoc vi tri cac phan tu
arr.reverse();
console.log(arr);

console.log('-------------array.concat ()------------------------');
// Noi 2 mang voi nhau, => tra ve mang gom tong phan tu 2 mang
var arr1 = ['Tu', 'hoc', 'Javascipt'];
var arr2 = ['basic', 'va', 'nang cao'];

arr3 = arr1.concat(arr2);
console.log(arr3);

console.log('-------------array.slice ()------------------------');
// Lay mot so phan tu cua mang
/*
@param start : vi tri bat dau
@param end : vi tri ket thuc

 */

var start = 1;
var end = 4;
var arr_4 = arr.slice(start, end);
console.log(arr_4);

console.log('------------------------------------');

var value = '';
function check(value){
    if(value){
        return true;
    }
    return false;
}
console.log(check(value));

console.log('------------------------------------');


// array : MAP , FILLTER,INDEXOF , FOREACH

var animals = [
    {
        'name' : 'cat',
        'size' : 'small',
        'weight' : 500,
    },
    {
        'name' : 'dog',
        'size' : 'medium',
        'weight' : 1000,
    },
    {
        'name' : 'lion',
        'size' : 'big',
        'weight' : 3000,
    },
    {
        'name' : 'mouse',
        'size' : 'small',
        'weight' : 200,
    }
]

var animals_name = animals.map((animal,index,animals)=>{
    return animal.name;
});
console.log(animals_name);
console.log('------------------------------------');


var animals_2 = animals.map((animal,index,animals)=>{
   return animal.weight * 3;
});
console.log(animals_2);
console.log('------------------------------------');

var animal_small =animals.filter((animal)=>{
   return animal.size === 'small';
});
console.log(animal_small);
console.log('------------------------------------');

var animal_name  = animals.map((animal)=>{
   return animal.name;
});
var pos = animal_name.indexOf('dog');
console.log(pos);
console.log('------------------------------------');



