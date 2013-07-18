<script language="javascript" type="text/javascript"><!--
        function verify(form)
        {
           var passed = false;
        var blnRetval, intAtSign, intDot, intComma, intSpace, intLastDot, intDomain, intStrLen;
        if (form.Email){
                       intAtSign=form.Email.value.indexOf("@");
                        intDot=form.Email.value.indexOf(".",intAtSign);
                        intComma=form.Email.value.indexOf(",");
                        intSpace=form.Email.value.indexOf(" ");
                        intLastDot=form.Email.value.lastIndexOf(".");
                        intDomain=intDot-intAtSign;
                        intStrLen=form.Email.value.length;
                // *** CHECK FOR BLANK EMAIL VALUE
                   if (form.Email.value == "" )
                   {
                alert("Nie wprowadzono adresu e-mail.");
                form.Email.focus();
                passed = false;
                }
                // **** CHECK FOR THE  @ SIGN?
                else if (intAtSign == -1)
                {

                alert("B³êdny adres e-mail \"@\".");
                        form.Email.focus();
                passed = false;

                }
                // **** Check for commas ****

                else if (intComma != -1)
                {
                alert("Adres e-mail nie mo¿e zawieraæ przecinka");
                form.Email.focus();
                passed = false;
                }

                // **** Check for a space ****

                else if (intSpace != -1)
                {
                alert("Adres e-mail nie mo¿e zawieraæ spacji.");
                form.Email.focus();
                passed = false;
                }

                // **** Check for char between the @ and dot, chars between dots, and at least 1 char after the last dot ****

                else if ((intDot <= 2) || (intDomain <= 1)  || (intStrLen-(intLastDot+1) < 2))
                {
                alert("Proszê wprowadziæ poprawny adres e-mail.\n" + form.Email.value + " jest b³êdny.");
                form.Email.focus();
                passed = false;
                }
                else {
                        passed = true;
                }
        }
        else    {
                passed = true;
        }
        return passed;
  }
  //--></script>