var module = {
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


};
        
       
           

