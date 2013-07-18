<script language="javascript">
<!--
   function FormatNumber(num)
   {
     if(isNaN(num)) { num = "0"; }
     sign = (num == (num = Math.abs(num)));
     num = Math.floor(num*100+0.50000000001);
     cents = num%100;
     num = Math.floor(num/100).toString();
     if(cents<10) { cents = "0" + cents; }
     for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
     {
       num = num.substring(0,num.length-(4*i+3))+','+ num.substring(num.length-(4*i+3));
     }
     return (((sign)?'':'-') + num + '.' + cents);
   }
  function showPrice(form)
  {  
    var myTotalPrice = 0;
    var showUP = 0;
    var myMathProblem = "";
    myItemPrice = parseFloat(form.nuPrice.value);
    for (var i = 0; i < form.elements.length; i++)
    {
      var e = form.elements[i];
      if ( e.type == 'select-one' )
      {
        showUP = 1;
        Item = e.selectedIndex;
        myPrice = e.options[Item].text;
        myDollarSign = myPrice.indexOf("$",0)
        if ( myDollarSign != "-1" )
        {
		  myPrice = myPrice.replace(".","");		
          myParSign = myPrice.indexOf(")", myDollarSign);
          myAttributeString = myPrice.substring(myDollarSign+1, myParSign);
          myAttributeString = myAttributeString.replace(/,/,"");
          myAttributePrice = parseFloat(myAttributeString);
          myMathProblem = myPrice.charAt(myDollarSign - 1);
        } else { myAttributePrice = 0; }
          if (myMathProblem == "-")
          {
            myTotalPrice = myTotalPrice - myAttributePrice;
          } else {
            myTotalPrice = myTotalPrice + myAttributePrice;
          }
      }
    }  
    if ( showUP )
    {
        myTotalPrice = FormatNumber(myTotalPrice + myItemPrice);
        document.getElementById("productNEWprice").innerHTML = "Subtotal Price with Options $" + myTotalPrice;
    }
  }  
//-->
</script>