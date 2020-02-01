$(function () {
    $(".tooltip").tooltip();
    //!this is getting which quaters are active and also which ones are n active and displaying them in the view.
    var activeQuater = $("#activeQuater").val();
    var gettingTheQuaterNumber = activeQuater.substr(1);
    var quaterPrefixId = "Quater" + gettingTheQuaterNumber;
    var gettingScoreValue = "scoreHidden" + gettingTheQuaterNumber;
    var value = $("#" + gettingScoreValue).val();

    var selectingQuaters = $("[id^=" + quaterPrefixId + "]");
    selectingQuaters.removeAttr("readonly");
    selectingQuaters.removeAttr("placeholder");
    selectingQuaters.attr("required", "true");
    selectingQuaters.css('border','3px solid #3C8DBC');
    quaterForLooping = parseFloat(gettingTheQuaterNumber, 10);

    console.log(quaterForLooping + typeof (quaterForLooping));

    for (let index = 1; index <= quaterForLooping; index++) {

        var quatersSelected = $("input[id*='Quater" + index + "']");
        
        quatersSelected.each(
            function () {
                
                //    console.log($(this).attr('id')); 
                //! the id of the input type is: 
                var id = $(this).attr('id');
                var slicedId = id.substring(7);
                var getTargetIdName = "target" + slicedId;
                var targetValue = parseFloat($("#" + getTargetIdName).text());
                var inputRawValue = $("#" + id).val();
                var inputValue = parseFloat($("#" + id).val());
                var period = $("#period" + slicedId).val();
                var arithmeticStructure = $("#arithmeticStructure" + slicedId);
                var arithmeticStructureValue = arithmeticStructure.val();
                var period = $("#period"+slicedId).val();
                period = parseFloat(period);
                var definigThis = $(this);
                switch (arithmeticStructureValue) {
                    case "0":

                    function validationCase0() {
                        if (inputValue > targetValue) {
                            definigThis.css('background-color','#fba7a7');
                        } else if(inputValue <= targetValue){
                            definigThis.css('background-color','#cfeda8'); 
                        }
                        else{
                            definigThis.css('background-color','#FFFFFF');
                        }

                        return "something";
                    }

                    switch (period) {
                        case 1:
                            validationCase0();                          
                        case 2:
                            validationCase0();                            
                        case 4:
                            validationCase0();                            
                        default:
                            break;
                    }                                

                        break;
                    case "1":

                        function validationCase1() {
                            if (inputValue < targetValue) {
                                definigThis.css('background-color','orange');
                            } else if(inputValue >= targetValue){
                                definigThis.css('background-color','#cfeda8'); 
                            }
                            else{
                                definigThis.css('background-color','#FFFFFF');
                            }
                        }
                            
                        switch (period) {
                            case 1:
                                validationCase1();
                                break;
                            case 2:
                                validationCase1();
                                break;
                            case 4:
                                // validationCase1();
                                if (inputValue < targetValue) {
                                    definigThis.css('background-color','#fba7a7');
                                } else if(inputValue >= targetValue){
                                    definigThis.css('background-color','#cfeda8'); 
                                }
                                else{
                                    definigThis.css('background-color','#FFFFFF');
                                }
                                break;
                            default:
                                break;
                        }
                        break;
                        case"3":
                        function validationCase2(params) {
                            if (inputValue > targetValue) {
                                definigThis.css('background-color','#fba7a7');
                            } else if(inputValue >= targetValue){
                                definigThis.css('background-color','#cfeda8'); 
                            }
                            else{
                                definigThis.css('background-color','#FFFFFF');
                            }
                        }
                        switch (period) {
                            case 1:
                                validationCase2();
                                break;
                            case 2:
                                validationCase2();
                                break;
                            case 4:
                                validationCase2();
                                break;
                            default:
                                break;
                        }
                        break;
                        case "4":
                            function validationCase3() {
                                if (inputValue < targetValue) {
                                    definigThis.css('background-color','#fba7a7');
                                } else if(inputValue >= targetValue){
                                    definigThis.css('background-color','#cfeda8'); 
                                } else{
                                    definigThis.css('background-color','#FFFFFF');
                                }
                            }
                            
                            switch (period) {
                                case 1:
                                    validationCase3();
                                    break;
                                case 2:
                                    validationCase3();
                                    break;
                                case 4:
                                    validationCase3();
                                    break;
                                default: 
                                break;
                            }
                        break;
                        case "5":
                            function validationCase4() {
                                if (inputValue > targetValue) {
                                    definigThis.css('background-color','#fba7a7');
                                } else if(inputValue >= targetValue){
                                    definigThis.css('background-color','#cfeda8'); 
                                } else{
                                    definigThis.css('background-color','#FFFFFF');
                                }
                            }
                            
                            switch (period) {
                                case 1:
                                    validationCase4();
                                    break;
                                case 2:
                                    validationCase4();
                                    break;
                                case 4:
                                    validationCase4();
                                    break;
                                default: 
                                break;
                            }
                        break;
                        case "6":

                            function validationCase5() {
                                if (inputValue > targetValue) {
                                    definigThis.css('background-color','#fba7a7');
                                } else if(inputValue >= targetValue){
                                    definigThis.css('background-color','#cfeda8'); 
                                } else{
                                    definigThis.css('background-color','#FFFFFF');
                                } 
                            }

                            switch (period) {
                                case 1:
                                    validationCase5();
                                    break;
                                case 2:
                                    validationCase5();
                                    break;
                                case 4:
                                    validationCase5();
                                    break;
                                default: 
                                break;
                            }
                        break;
                        case "7":

                        function validationCase6(params) {
                            if (inputValue > targetValue) {
                                definigThis.css('background-color','#fba7a7');
                            } else if(inputValue >= targetValue){
                                definigThis.css('background-color','#cfeda8'); 
                            } else{
                                definigThis.css('background-color','#FFFFFF');
                            }
                        }
                        switch (period) {
                            case 1:
                                validationCase6();
                                break;
                            case 2:
                                validationCase6();
                                break;
                            case 4:
                                validationCase6();
                                break;
                            default: 
                            break;
                        }
                        break;
                    default:
                        break;
                }

            }
        );
        // console.log(quatersSelected);

    }
    //!on loading the page successfully hide the two types of perspectives that will be used by the uer to bring the perspectives to li

    //! the next section isused to get the 

});
