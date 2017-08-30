var module_algo = {
    p_1 : function () {
        // Generate two numbers, both < 10
        return math.randomMax(10,10);
    },

    p_2 : function () {
        // Generate two numbers, both < 20
        return math.randomMax(20,20);
    },

    p_3 : function () {
        // Generate two numbers, both < 50
        return math.randomMax(50,50);
    },

    p_4 : function () {
        // Generate two numbers, the sum < 100
        return math.randomSum(100);
        alert();
    },

    p_5 : function () {
        // Generate two numbers, sum < 1,000
        return math.randomSum(1000);
    },

    p_6 : function () {
        // Generate two numbers, sum < 10,000
        return math.randomSum(10000);
    },

    p_7 : function () {
        // Generate two numbers, sum < 100,000
        return math.randomSum(100000);
    },

    p_8 : function () {
        // Generate two numbers, sum < 1,000,000
        return math.randomSum(1000000);
    },

    p_9 : function () {
        // Generate two numbers, sum < 10,000,000
        return math.randomSum(10000000);
    },

    p_10 : function () {
        // Generate 4 numbers for fractions
        // a. Top numbers < 12
        // b. Bottom numbers < 12
        return math.fractionMax(12,12,12,12);
    },

    p_11 : function () {
        // Generate 4 numbers for fractions
        // a. Top numbers < 20
        // b. Bottom numbers < 20
        return math.fractionMax(20,20,20,20);
    },

    p_12 : function () {
        // Generate 4 numbers for fractions
        // a. Top numbers < 50
        // b. Bottom numbers < 50
        return math.fractionMax(50,50,50,50);
    },

    p_13 : function () {
        // Generate 4 numbers for fractions
        // a. Top numbers < 100
        // b. Bottom numbers < 100
        return math.fractionMax(100,100,100,100);
    },

    p_14 : function () {
        // Generate two numbers, number 1: < 10, number 2 < 10
        return math.randomMax(10,10);
    },

    p_15 : function () {
        // Generate two numbers, number 1: < 10, number 2 < 100
        return math.randomMax(10,100);
    },

    p_16 : function () {
        // Generate two numbers, number 1: < 100, number 2 < 1000
        return math.randomMax(100,1000);
    },

    p_17 : function () {
        // Generate two numbers, number 1: < 1000, number 2 < 1000
        return math.randomMax(1000,1000);
    },

    p_18 : function () {
        // Generate two numbers, number 1: < 1000, number 2 < 100
        return math.randomMax(1000,100);
    },

    p_19 : function () {
        // Generate two numbers, number 1: < 100, number 2 < 10
        return math.randomMax(100,10);
    },

    p_20 : function () {
        // Generate two numbers, number 1: < 12, number 2 < 12
        return math.randomMax(12,12);
    },
    p_21 : function(){
        // Generate two random numbers, the product (multiplication) does not exceed 144
        return math.productMax(144);
    },
    p_22 : function(){
        // Generate two random numbers, the product (multiplication) does not exceed 1000
        return math.productMax(1000);
    },
    p_23 : function(){
        // Generate two random numbers, if number 2 is divided by number 1, there is no remainder
        return math.random_division();
    },
    p_24 : function(){
        //Generate three numbers, all numbers added together < 10
        return math.random_three_number(10);
    },
    p_25 : function(){
        //Generate three numbers, all numbers added together < 100
        return math.random_three_number(100);
    },
    p_26 : function(){
        //Generate three numbers, all numbers added together < 1000
        return math.random_three_number(1000);
    },
    p_27 : function(){
        //Generate three numbers, all numbers added together < 10000
        return math.random_three_number(10000);
    },
    p_28 : function(){
        //Generate four numbers, all numbers added together < 1000
        return math.random_four_number(1000);
    },
    p_29 : function(){
        //Generate four numbers, all numbers added together < 10000
        return math.random_four_number(10000);
    },
    p_30 : function(){
        //Generate three numbers, all numbers multiplied together < 1,000
        return math.random_three_productNumber(1000);
    },
    p_31 : function(){
        //Generate three numbers, all numbers multiplied together < 10000
        return math.random_three_productNumber(10000);
    },
    p_32 : function(){
        //Generate four numbers, all numbers multiplied together < 1000
        return math.random_four_productNumber(1000);
    },
    p_33 : function(){
        //Generate four numbers, all numbers multiplied together < 10000
        return math.random_four_productNumber(10000);
    },
    p_34 : function(){
        //Generate two numbers for division, #1<100 #2<10
        return math.random_division_under100_10(100,10);
    },

    p_35 : function(){
        //Generate two numbers for division, #1<1000 #2<10
        return math.random_division_under1000_10(1000,10);
    },

    p_36 : function(){
        //Generate two numbers for division, #1<1000 #2<100
        return math.random_division_under1000_100(1000,100);
    },

    p_37 : function(){
        //Generate two numbers for decimal, number less than 2 decimal
        return math.random_decimal_2(1000,1000);
    },

    p_38 : function(){
        //Generate two numbers for decimal, number less than 3 decimal
        return math.random_decimal_3(1000,1000);
    },

    p_39 : function(){
        //Generate two numbers for decimal, number less than 4 decimal
        return math.random_decimal_4(1000,1000);
    },

    p_40 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        return math.random_decimal_5(1000,1000);
    },

    p_41 : function(){
        //?. Generate two numbers, number 1: < 100, number 2 < 10, number 1>number 2
        return math.randomMax1(100,10);
    },
    p_42 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        return math.randomMax1(1000,100);
    },
    p_43 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        return math.randomMax1(1000,1000);
    },
    p_44 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 10000);
        maxNum2 = Math.floor(Math.random() * 4500)+5000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
        if(randomNumber2 < 4500){
            randomNumber2 = 4500 + Math.floor(Math.random() * 200);
        }

    },
    p_45 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 100000);
        maxNum2 = Math.floor(Math.random() * 50000)+50000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
        if(randomNumber2 < 50000){
            randomNumber2 = 50000 + Math.floor(Math.random() * 3000);
        }

    },
    p_46 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        return math.randomMax1(20,19);
    },
    p_47 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 30)+20;
        maxNum2 = Math.floor(Math.random() * 30)+10;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;

    },
    p_48 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 1000000);
        maxNum2 = Math.floor(Math.random() * 400000)+100000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;

    },
    p_49 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 1000000);
        maxNum2 = Math.floor(Math.random() * 500000)+500000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
        if(randomNumber2<500000){
            randomNumber2 = 500000 + Math.floor(Math.random() * 11300);
        }

    },
    p_50 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 10000000);
        maxNum2 = Math.floor(Math.random() * 5000000)+5000000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
        if(randomNumber2<5000000){
            randomNumber2 = 5000000 + Math.floor(Math.random() * 111300);
        }

    },
    p_51 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 10000000);
        maxNum2 = Math.floor(Math.random() * 9000000)+1000000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
        if(randomNumber2<1000000){
            randomNumber2 = 1000000 + Math.floor(Math.random() * 12340);
        }

    },
    p_52 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 100000);
        maxNum2 = Math.floor(Math.random() * 40000)+10000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
        if(randomNumber2<10000){
            randomNumber2 = 10000 + Math.floor(Math.random() * 560);
        }
    },
    p_53 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        maxNum1 = Math.floor(Math.random() * 10000);
        maxNum2 = Math.floor(Math.random() * 4000)+1000;

        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
        if(randomNumber2<1000){
            randomNumber2 = 1000 + Math.floor(Math.random() * 120);
        }
    },
    p_54 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        return math.randomMax1(10,10);
    },
    p_55 : function(){
        //Generate two numbers for decimal, number less than 5 decimal
        return math.randomMax1(1000,100);
    },


};


//Operations functions
var math = {
    randomMax : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator(max_number1);
        randomNumber2 =  math.randomNumGenerator(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },

    randomMax1 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        maxNum1 = math.randomNumGenerator(max_number1);
        maxNum2 =  math.randomNumGenerator(max_number2);
        var max = maxNum1>maxNum2 ? maxNum1 : maxNum2;
        var min = maxNum1<maxNum2 ? maxNum1 : maxNum2;
        randomNumber1 = max;
        randomNumber2 = min;
    },

    random_decimal_2 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator1(max_number1);
        randomNumber2 =  math.randomNumGenerator1(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },
    random_decimal_3 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator2(max_number1);
        randomNumber2 =  math.randomNumGenerator2(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },
    random_decimal_4 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator3(max_number1);
        randomNumber2 =  math.randomNumGenerator3(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },
    random_decimal_5 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator4(max_number1);
        randomNumber2 =  math.randomNumGenerator4(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },
    random_division_under100_10 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator(max_number1);
        randomNumber2 =  math.randomNumGenerator(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },
    random_division_under1000_10 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator(max_number1);
        randomNumber2 =  math.randomNumGenerator(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },
    random_division_under1000_100 : function(max_number1,max_number2){
        // sample code reusing the single random generator with max limit
        randomNumber1 = math.randomNumGenerator(max_number1);
        randomNumber2 =  math.randomNumGenerator(max_number2);

        return{
            randomNumber1,
            randomNumber2
        };
    },

    productMax:function(productMax_num){
        p = 1;
        while(p){
            randomNumber1 = math.randomNumGenerator(productMax_num);
            randomNumber2 = math.randomNumGenerator(productMax_num);
            random_Sum = randomNumber1 * randomNumber2;
            if(random_Sum < productMax_num){
                p = 0;
                return {
                    randomNumber1,
                    randomNumber2
                };
            }
        }
    },

    random_three_productNumber:function(productMax_num){
        p = 1;
        while(p){
            randomNumber1 = math.randomNumGenerator(productMax_num);
            randomNumber2 = math.randomNumGenerator(productMax_num);
            randomNumber3 = math.randomNumGenerator(productMax_num);
            random_Sum = randomNumber1 * randomNumber2 * randomNumber3;
            if(randomNumber1 !=0 && randomNumber2 !=0 && randomNumber3 !=0 && random_Sum < productMax_num){
                p = 0;
                return {
                    randomNumber1,
                    randomNumber2,
                    randomNumber3
                };
            }
        }
    },

    random_four_productNumber:function(productMax_num){
        p = 1;
        while(p){
            randomNumber1 = math.randomNumGenerator(productMax_num);
            randomNumber2 = math.randomNumGenerator(productMax_num);
            randomNumber3 = math.randomNumGenerator(productMax_num);
            randomNumber4 = math.randomNumGenerator(productMax_num);
            random_Product = randomNumber1 * randomNumber2 * randomNumber3 * randomNumber4;
            if(randomNumber1 !=0 && randomNumber2 !=0 && randomNumber3 !=0 && randomNumber4 !=0 && random_Product < productMax_num){
                p = 0;
                return {
                    randomNumber1,
                    randomNumber2,
                    randomNumber3,
                    randomNumber4
                };
            }
        }
    },


    random_three_number : function(max_sum){
        p = 1;
        while(p){
            randomNumber1 = math.randomNumGenerator(max_sum);
            randomNumber2 = math.randomNumGenerator(max_sum);
            randomNumber3 = math.randomNumGenerator(max_sum);
            random_Sum = randomNumber1+randomNumber2 + randomNumber3;
            if(random_Sum < max_sum){
                p = 0;
                return {
                    randomNumber1,
                    randomNumber2,
                    randomNumber3
                };
            }
        }
    },

    random_four_number : function(max_sum){
        p = 1;
        while(p){
            randomNumber1 = math.randomNumGenerator(max_sum);
            randomNumber2 = math.randomNumGenerator(max_sum);
            randomNumber3 = math.randomNumGenerator(max_sum);
            randomNumber4 = math.randomNumGenerator(max_sum);
            random_Sum = randomNumber1+randomNumber2 + randomNumber3 + randomNumber4;
            if(random_Sum < max_sum){
                p = 0;
                return {
                    randomNumber1,
                    randomNumber2,
                    randomNumber3,
                    randomNumber4
                };
            }

        }
    },


    random_division : function(){
        p = 1;
        while(p){
            randomNumber1 = Math.floor(Math.random()*1000);
            randomNumber2 = Math.floor(Math.random()*1000);

            if(randomNumber1 !=0 && randomNumber2 % randomNumber1 == 0){
                p = 0;
                return {
                    randomNumber1,
                    randomNumber2
                };
            }

        }
    },


    randomSum : function(max_sum){
        // put here code to generate 2 random numbers with sum limit
        p = 1;
        while(p){
            randomNumber1 = math.randomNumGenerator(max_sum);
            randomNumber2 = math.randomNumGenerator(max_sum);
            random_Sum = randomNumber1+randomNumber2;
            if(random_Sum < max_sum){
                p = 0;
                return {
                    randomNumber1,
                    randomNumber2
                };
            }
        }
    },

    fractionMax : function(max_number1,max_number2,max_number3,max_number4){
        // sample code reusing the single random generator with max limit

        randomNumber1 = math.randomNumGenerator(max_number1);
        randomNumber2 = math.randomNumGenerator(max_number2);
        randomNumber3 = math.randomNumGenerator(max_number3);
        randomNumber4 = math.randomNumGenerator(max_number4);
        return{
            randomNumber1,
            randomNumber2,
            randomNumber3,
            randomNumber4
        };
    },

    randomNumGenerator : function(max_num){
        // alert(max_num);
        randomNumber = Math.floor(Math.random() * max_num);

        return randomNumber;
    },
    randomNumGenerator1 : function(max_num){
        // alert(max_num);
        randomNumber = (Math.random() * max_num).toFixed(2);

        return randomNumber;
    },
    randomNumGenerator2 : function(max_num){
        // alert(max_num);
        randomNumber = (Math.random() * max_num).toFixed(3);

        return randomNumber;
    },
    randomNumGenerator3 : function(max_num){
        // alert(max_num);
        randomNumber = (Math.random() * max_num).toFixed(4);

        return randomNumber;
    },
    randomNumGenerator4 : function(max_num){
        // alert(max_num);
        randomNumber = (Math.random() * max_num).toFixed(5);

        return randomNumber;
    },


};




