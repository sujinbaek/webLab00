"use strict"
var stack = [];
window.onload = function () {
    var displayVal = "0";
    var flag = "0";
    for (var i in $$('button')) {
        $$('button')[i].onclick = function () {
            var value = $(this).innerHTML;
            if (flag=="0" && !isNaN(parseInt(value))) {
                if (displayVal.charAt(0) == '0') {
                    displayVal = value;
                }
                else {
                    displayVal += value;
                }

                if (document.getElementById('expression').innerHTML.charAt(0)=='0') {
                    document.getElementById('expression').innerHTML = displayVal;
                }
                else {
                    document.getElementById('expression').innerHTML += value;
                }
            }
            else if (value == "AC") {
                flag = "0";
                displayVal = "0";
                stack = [];
                document.getElementById('expression').innerHTML = "0";
            }
            else if (flag=="0" && value == ".") {
                if (displayVal.indexOf(".") < 0) {
                    displayVal += ".";
                } 
                if (document.getElementById('expression').innerHTML.charAt(0)=='0') {
                    document.getElementById('expression').innerHTML = displayVal;
                }
                else {
                    document.getElementById('expression').innerHTML += value;
                }
            }
            else if (flag=="0" && value == "(" || value == ")") {
                if (value == "(" && displayVal != "0") {
                    stack.push(parseFloat(displayVal));
                    stack.push("*");
                    displayVal = "0";
                }
                else if (value == ")") {
                     stack.push(parseFloat(displayVal));
                }
                stack.push(value);

                if (document.getElementById('expression').innerHTML.charAt(0)=='0') {
                    document.getElementById('expression').innerHTML = value;
                }
                else {
                    document.getElementById('expression').innerHTML += value;
                }
                displayVal = "0";
            }
            else {
                if (flag == "0") {
                    if (displayVal != "0") {
                        if (stack[stack.length-1] == ")") {
                            stack.push("*");
                        }
                        stack.push(parseFloat(displayVal));
                    }
                    
                    document.getElementById('expression').innerHTML += " " + value + " ";

                    displayVal = "0";
                    
                    if (value=="=") {
                        if (isValidExpression(stack)) {
                            stack = infixToPostfix(stack);
                            displayVal = postfixCalculate(stack);
                            if (isNaN(displayVal)) {
                                flag = 1;
                             // displayVal = "0";
                             //    stack = [];
                             //    document.getElementById('expression').innerHTML = "0";
                            }
                            else {
                                document.getElementById('expression').innerHTML += " " + displayVal;
                            }
                        }
                        else {
                            flag=1;
                        }
                    } else {
                        stack.push(value);
                    }
                }
            } 

            $('result').innerHTML = displayVal;
        };
    }
}
function isValidExpression(s) {
    var tmp = [];
    for (var i=0; i<s.length; i++) {
        if (s[i] == "(") {
            tmp.push("(");
        }
        else if (s[i] == ")") {
            if (tmp.length == 0) 
                return false;
            var t = tmp.pop();
            if (t == "(" && s[i] != ")")
                return false;
        }
    }

    // if (tmp.length == 0)
    //     return false;

    return true;
}

function infixToPostfix(s) {
    var priority = {
        "+":0,
        "-":0,
        "*":1,
        "/":1
    };
    var tmpStack = [];
    var result = [];
    for(var i =0; i<stack.length ; i++) {
        if(/^[0-9]+$/.test(s[i])){
            result.push(s[i]);
        } else {
            if(tmpStack.length === 0){
                tmpStack.push(s[i]);
            } else {
                if(s[i] === ")"){
                    while (true) {
                        if(tmpStack.last() === "("){
                            tmpStack.pop();
                            break;
                        } else {
                            result.push(tmpStack.pop());
                        }
                    }
                    continue;
                }
                if(s[i] ==="(" || tmpStack.last() === "("){
                    tmpStack.push(s[i]);
                } else {
                    while(priority[tmpStack.last()] >= priority[s[i]]){
                        result.push(tmpStack.pop());
                    }
                    tmpStack.push(s[i]);
                }
            }
        }
    }
    for(var i = tmpStack.length; i > 0; i--){
        result.push(tmpStack.pop());
    }
    return result;
}

function postfixCalculate(s) {
    var op1;
    var op2;
    var val;

    var tmpStack = [];
    for (var i=0; i<s.length; i++) {
        if (!isNaN(s[i])) {
            tmpStack.push(s[i]);
        }
        else {
            op1 = tmpStack.pop();
            op2 = tmpStack.pop();
            
            switch (s[i]) {
                case "+":
                    val = op2 + op1;
                    break;
                case "-":
                    val = op2 - op1;
                    break;
                case "*":
                    val = op2 * op1;
                    break;
                case "/":
                    val = op2 / op1;
                    break;
                default:
                    break;
            }
            tmpStack.push(val);
        }
    }

    return tmpStack.pop();
}
