## Proof of Concept

All files located in the `app` folder.

The best practice method for me would be to extract the product into separate classes, one for physical and one for digital, this means each one can have its own set of attributes and methods if
needed, but these would
always extend a base class which contains methods relevant and accessible to both.

Enums are used to control which languages we support, enforcing database integrity and eliminating typos.

Interfaces are used to enforce methods and make sure future products include all required methods.

Prices, countries, and visibility are set into child tables from the main products allowing multiple of each to be added/extended in the future and helping to separate the logic into their areas
keeping the code clean and lean.

Conditions for the products are added into the prices table and they directly (normally) effect the price and warranty etc of the product.
this also allows the product to exist and have multiple conditions.

Stock can then be controlled and displayed for each product for different conditions.

Tests would be added (I ran out of time :-) ) to all files to ensure the correct relationships are being created and the correct data is being returned.

The main product interface would also use polymorphism to return the correct product type based on when they are after or both types, allows the correct
methods to be accessed against each product. Allowing the overridden methods to be correctly called.
