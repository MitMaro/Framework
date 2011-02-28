## Modules ##
***

### Logic ###

** Syntax definition **

Not sure how accurate this is, this is the first time I ever wrote a formal syntax definition.

    statements           = statement ;
    statement            = statement, { white space }, operator, { white space }, statement ;
    statement            = statement, { white space }, operator, { white space }, statement ;
    statement            = expression, { white space }, operator, { white space }, statement ;
    statement            = expression, { white space }, operator, { white space }, expression ;
    statement            = unary operator, { white space }, statement ;
    statement            = unary operator, { white space }, expression ;
    statement            = "(", { white space }, statement, { white space }, ")" ;
    expression           = type, white space, value ;
    expression           = type, white space, quoted value ;
    expression           = type, white space, variable ;
    operator             = "&&" | "==" | ">=" | ">" | "===" | "<=" | "<" | "!=" | "!==" | "||" ;
    unary operator       = "!" ;
    type                 = "Boolean" | "Float" | "Integer" | "String" ;
    variable             = "$", alpha numeric , { alpha numeric } ;
    value                = alpha numeric, { alpha numeric } ;
    quoted value         = '"' , { all characters - '"', "\"" } , '"' ;
    alphabetic character = "A" | "B" | "C" | "D" | "E" | "F" | "G"
                           | "H" | "I" | "J" | "K" | "L" | "M" | "N"
                           | "O" | "P" | "Q" | "R" | "S" | "T" | "U"
                           | "V" | "W" | "X" | "Y" | "Z" | "a" | "b"
                           | "c" | "d" | "e" | "f" | "g" | "h" | "i"
                           | "j" | "k" | "l" | "m" | "n" | "o" | "p"
                           | "q" | "r" | "s" | "t" | "u" | "v" | "w"
                           | "x" | "y" | "z" ;
    digit                = "0" | "1" | "2" | "3" | "4" | "5" | "6" | "7" | "8" | "9" ;
    alpha numeric        = alphabetic character | digit ;
    white space          = ? white space characters ? ;
    all characters       = ? all visible characters ? ;

** Current Limitations **

* Some values such as negative numbers need to be enclosed in quotes for them to work.
* Delimiters can be mixed
