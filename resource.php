<?php

class myResource
{
	// Navigation
	public $nvHome			= 'Home';
	public $nvInventory 	= 'Products';
	public $nvPurchase 		= 'Purchase';
	public $nvSales			= 'Orders';
	public $nvReports		= 'Reports';
	public $nvManagement	= 'Management';
	public $nvSettings		= 'Settings';
	public $nvHelp			= 'Help';
	public $nvApp			= 'APP';
	public $nvHelpContact	= 'Contact';
	
	// Home page
	public $fmHomeTitle 	= 'Home';
	public $fmHomeBtn1 		= 'New Order';
	public $fmHomeBtn2 		= 'New Purchase';
	public $fmHomeBtn3 		= 'Products';
	public $fmHomeBtn4 		= 'Management';
	public $fmHomeBtn5 		= 'Reports';
	public $fmHomeBtn6 		= 'Settings';
	public $fmHomeBtn7 		= 'Products';
	public $fmHomeBtn8 		= '';
	
	// inv.php
	public $fmInvTitle			= 'Inventory Management';
	public $fmInvTitleMsg1		= 'Total Inventories: ';
	public $fmInvTitleMsg2		= ' SKU ';
	public $fmInvTitleMsg3		= ' units';
	public $fmInvTitleMsg4		= ' EUR';
	public $fmInvBtn1			= 'New';
	public $fmInvBtn2			= 'Add';
	public $fmInvBtn3			= 'Batch';
	public $fmInvBtn4			= 'Query';
	public $fmInvBtn5			= 'Suppliers';
	public $fmInvBtn6			= 'Categories';
	
	// inv_search.php
	public $fmInvSrchTitle		= 'Search Product';
	public $fmInvSrchMsgBefore	= 'Please enter Article Code. to search.';
	public $fmInvSrchMsgYes		= 'Product found. Do you want to use this product?';
	public $fmInvSrchMsgNo		= 'No product found. Do you want to create a new product?';
	public $fmInvSrchMsgChoose	= 'Please select one product.';
	public $fmInvSrchCapCode	= 'Code';
	public $fmInvSrchCapId		= 'ID';
	public $fmInvSrchCapImage	= 'Image';
	public $fmInvSrchCapData	= 'Data';
	public $fmInvSrchCapCount	= 'Count';	
	public $fmInvSrchCapCost	= 'Cost';
	public $fmInvSrchBtnSearch	= 'Search';
	public $fmInvSrchBtnBack	= 'Cancel';
	public $fmInvSrchBtnShow	= 'Choose this product';
	public $fmInvSrchBtnNew		= 'Create new product';
	
	// inv_view.php
	public $fmInvNewTitle		= 'Product';
	public $fmInvNewTitleNew	= 'New Product';
	public $fmInvNewBtnBack		= 'Back';
	public $fmInvNewBtnSave		= 'Save';
	public $fmInvNewBtnPrint	= 'Barcode';
	public $fmInvNewBtnPhoto	= 'Photo';
	public $fmInvNewBtnLog		= 'Log';
	public $fmInvNewBtnAdd		= 'Add';
	public $fmInvNewBtnEdit		= 'Edit';
	public $fmInvNewBtnMDel		= 'Delete';
	public $fmInvNewBtnMClose	= 'Close';
	public $fmInvNewCapId		= 'ID';
	public $fmInvNewCapCode		= '*Code';
	public $fmInvNewCapName		= 'Name';
	public $fmInvNewCapVariant	= 'Variant';
	public $fmInvNewCapCode1	= 'Code 1';
	public $fmInvNewCapCode2	= 'Code 2';
	public $fmInvNewCapType		= 'Type';
	public $fmInvNewCapSup		= 'Supplier';
	public $fmInvNewCapCost		= '*Cost';
	public $fmInvNewCapPrice	= '*Price';
	public $fmInvNewCapCountNew	= '*New';
	public $fmInvNewCapCount	= '*Qty';
	public $fmInvNewCapCountA	= '*Available';	
	public $fmInvNewCapNote		= 'Note';
	public $fmInvNewCapBarcode	= 'Barcode';
	public $fmInvNewCapDisc		= 'Discount';
	public $fmInvNewCapHTitle	= 'Log History';
	public $fmInvNewCapHTime	= 'Time';
	public $fmInvNewCapHAmount	= 'Units';
	public $fmInvNewCapHCost	= 'Cost';
	public $fmInvNewCapHSource	= 'Action';
	public $fmInvNewCapATitle	= 'Add Inventory';
	public $fmInvNewCapACount	= 'Amount';
	public $fmInvNewCapACost	= 'Cost';
	public $fmInvNewCapETitle	= 'Edit Inventory';
	public $fmInvNewCapECount	= 'Amount';
	public $fmInvNewCapECost	= 'Cost';
	public $fmInvNewMsgEdit		= 'Do you really want to modify inventory?';
	public $fmInvNewCapPos		= 'Position';
	public $fmInvNewCapColor	= 'Color';
	public $fmInvNewSupTitle	= 'New Supplier';
	public $fmInvNewSupID		= 'Supplier ID *';
	public $fmInvNewSupName		= 'Supplier Name *';
	public $fmInvNewTypeTitle	= 'New Type';
	public $fmInvNewTypename	= 'Type Name *';
	public $fmInvNewUnitTitle	= 'Units';
	public $fmInvNewUnitType	= 'Unit Type';
	public $fmInvNewUnitQty		= 'Qty';
	public $fmInvNewUnitNew		= 'New';
	public $fmInvNewUnitChoose	= 'Choose';
	public $fmInvNewVarAdd		= 'Add Variant';
	public $fmInvNewVarName		= 'Variant: ';
	public $fmInvNewVarCount	= 'Qty: ';
	public $fmInvNewVarBarcode	= 'Barcode :';	
	public $fmInvNewVarNum		= 'Variants:';
	public $fmInvNewVarTotal	= 'Qty:';
	public $fmInvNewVarNew		= 'New Variant';
	public $fmInvNewVarEdit		= 'Edit Variant';
	
	// inv_mgt.php
	public $fmInvMgtTitle		= 'Product List';
	public $fmInvMgtCapCode		= 'Artikel Nr.';
	public $fmInvMgtBtnBack		= 'Back';
	public $fmInvMgtBtnAll		= 'Refresh';
	public $fmInvMgtCapId		= 'ID';
	public $fmInvMgtCapImage	= 'Photo';
	public $fmInvMgtCapData		= 'Data';
	public $fmInvMgtCapCount	= 'Amount';
	public $fmInvMgtCapCost		= 'Cost';	
	public $fmInvMgtTime		= 'Time';
	public $fmInvMgtSort		= 'Sort';
	public $fmInvMgtSUpdated	= 'Newest Updated';
	public $fmInvMgtSCreated	= 'Newest Created';
	public $fmInvMgtSCodeAZ		= 'Code A-Z';
	public $fmInvMgtSCodeZA		= 'Code Z-A';
	public $fmInvMgtSCountDesc	= 'Stock More First';
	public $fmInvMgtSCountAsc	= 'Stock Low First';
	public $fmInvMgtSCostDesc	= 'Cost More First';
	public $fmInvMgtSCostAsc	= 'Cost Less First';
	public $fmInvMgtCapSup		= 'Supplier';
	public $fmInvMgtCapType		= 'Type';
	public $fmInvMgtCapCountT	= 'Total Amount';
	public $fmInvMgtCapCostT	= 'Total Cost';
	public $fmInvMgtCapAllT		= 'Total';
	public $fmInvMgtFSupAll		= 'All';
	public $fmInvMgtFSupX		= 'Unknown';
	public $fmInvMgtFTypeAll	= 'All';
	public $fmInvMgtFTypeX		= 'Unknown';
	public $fmInvMgtBtnNew		= 'New';
	
	// inv_hist.php
	public $fmInvHistTitle		= 'Inventory History';
	public $fmInvHistCapId		= 'ID';
	public $fmInvHistCapName	= 'Name';
	public $fmInvHistCapCount	= 'Units';
	public $fmInvHistCapCountA	= 'Available';
	public $fmInvHistCapSelTime	= 'Time';
	public $fmInvHistBtnBack	= 'Close';
	public $fmInvHistBtnQuery	= 'Query';
	public $fmInvHistCapTimeFrom = 'From';
	public $fmInvHistCapTimeTo	= 'To';
	public $fmInvHistCapTime	= 'Time';
	public $fmInvHistCapAmount	= 'Units';
	public $fmInvHistCapAmountA	= 'Available';
	public $fmInvHistCapUser	= 'User';
	public $fmInvHistCapSource	= 'Source';
	
	// Inventory statistics
	public $fmInvStatTitle 		= 'Statistics';
	public $fmInvStatBtnBack 	= 'Back';
	public $fmInvStatCapSName 	= 'Supplier';
	public $fmInvStatCapSCount 	= 'Count';
	public $fmInvStatCapTName 	= 'Type';
	public $fmInvStatCapTCount 	= 'Count';
	public $fmInvStatTabSup 	= 'Suppliers';
	public $fmInvStatTabType 	= 'Types';
	
	// inv_batch.php
	public $fmBatchTitle		='Batch Add';
	public $fmBatchTitleSub		='Enter purchase order data';
	public $fmBatchCapId		='Batch ID';
	public $fmBatchCapSpId		='Purchase No.';
	public $fmBatchCapSup		='Supplier';
	public $fmBatchCapTime		='Time';
	public $fmBatchCapNote		='Note';
	
	// purchase.php
	public $fmPurTitle			= 'New Purchase';
	public $fmPurBtnBack		= 'Back';
	public $fmPurCapId			= 'ID';
	public $fmPurCapPurId		= 'Purchase ID';
	public $fmPurCapHId			= 'ID';
	public $fmPurCapHSpId		= 'No.';
	public $fmPurCapHSpDate		= 'Date';
	public $fmPurCapHSName		= 'Supplier';
	public $fmPurCapHNote		= 'Note';
	public $fmPurCapItem		= 'Item';
	public $fmPurCapAmount		= 'Units';
	public $fmPurCapCost		= 'Cost';
	public $fmPurTitleModal		= 'Purchase Data';
	public $fmPurBtnModalClose	= 'Close';
	public $fmPurMsgDel			= 'Do you really want to delete this?';
	
	// Purchase Management
	public $fmPurMgtTitle		= 'Purchase Management';
	public $fmPurMgtCapCId		= 'ID';
	public $fmPurMgtCapCSPId	= 'SP ID';
	public $fmPurMgtCapCDate	= 'Date';
	public $fmPurMgtCapCName	= 'Supplier';
	public $fmPurMgtCapCTotal	= 'Total';
	public $fmPurMgtCapCStatus	= 'Status';
	public $fmPurMgtBtnBack		= 'Status';
	public $fmPurMgtBtnAll		= 'Search All';
	public $fmPurMgtBtnView		= 'View';
	
	// inv_types.php
	public $fmTypesTitle		= 'Product Types';
	public $fmTypesTitleSub		= 'Select type to edit';
	public $fmTypesTitleEdit	= 'Edit Types';
	public $fmTypesTitleAdd		= 'Add Types';
	public $fmTypesBtnBack		= 'Back';
	public $fmTypesBtnEdit		= 'Edit';
	public $fmTypesBtnAdd		= 'Add';
	public $fmTypesBtnCancel	= 'Cancel';
	public $fmTypesBtnNewl		= 'New';
	public $fmTypesCapId		= 'ID';
	public $fmTypesCapName		= 'Name';
	public $fmTypesMsg			= 'Please select one product type.';
	
	// inv_suppliers.php
	public $fmSupsTitle			= 'Suppliers';
	public $fmSupsTitleSub		= 'Select supplier to view';
	public $fmSupsBtnBack		= 'Back';
	public $fmSupsBtnView		= 'View';
	public $fmSupsBtnNew		= 'New';
	public $fmSupsCapId			= 'ID';
	public $fmSupsCapName		= 'Name';
	public $fmSupsCapTel		= 'Tel';
	public $fmSupsCapContact	= 'Contact';
	public $fmSupsMsg			= 'Please select one supplier.';
	
	// supplier.php
	public $fmSupVTitle			= 'Supplier';
	public $fmSupVBtnBack		= 'Back';
	public $fmSupVBtnSave		= 'Save';
	public $fmSupVCapId			= 'ID';
	public $fmSupVCapName		= 'Name';
	public $fmSupVCapTel		= 'Tel';
	public $fmSupVCapAddr		= 'Address';
	public $fmSupVCapPost		= 'Post';
	public $fmSupVCapCity		= 'City';
	public $fmSupVCapCountry	= 'Country';
	public $fmSupVCapContact	= 'Contact Person';
	public $fmSupVCapEmail		= 'E-Mail';
	
	// Order page
	public $fmOrderBtnInvoice	= 'Invoice';
	public $fmOrderCapPhoto		= 'Photo';
	public $fmOrderCapItem		= 'ART#';
	public $fmOrderCapCount		= 'NUM';
	public $fmOrderCapPrice		= 'Price';
	public $fmOrderCapSubtotal	= 'Total';
	public $fmOrderTotalNum		= 'Items:';
	public $fmOrderTotal		= 'Gross:';
	public $fmOrderNet			= 'Net:';
	public $fmOrderPaid			= 'Paid:';
	public $fmOrderUnpaid		= 'Due:';
	public $fmOrderTableEmpty	= 'Please press "+" to add item';
	public $fmOrderSrchTitle	= 'Please enter Artikel No.';
	public $fmOrderSrchArt		= 'ART#';
	public $fmOrderItemTitle	= 'Order Item';
	public $fmOrderItemArt		= 'ART#';
	public $fmOrderItemName		= 'Name';
	public $fmOrderItemUnit		= 'Unit';
	public $fmOrderItemStock	= 'Stock';
	public $fmOrderItemCount	= 'Amount';
	public $fmOrderItemVar		= 'Variant';
	public $fmOrderItemPrice	= 'Price';
	public $fmOrderDisTitle		= 'Discount';
	public $fmOrderDisRate		= 'Rate (%)';
	public $fmOrderDisValue		= 'Value';
	public $fmOrderFeeTitle		= 'Fees';
	public $fmOrderFeeShipping	= 'Shipping';
	public $fmOrderFeeBank		= 'Bank';
	public $fmOrderFeeNach		= 'Nachnahme';
	public $fmOrderFeeOther		= 'Other';
	public $fmOrderPayTitle		= 'Payment';
	public $fmOrderPayAmount	= 'Balance';
	public $fmOrderPayMethod	= 'Method';
	public $fmOrderPayValue		= 'Value';
	public $fmOrderPayTotal		= 'Total';
	public $fmOrderPayPaid		= 'Paid';
	public $fmOrderPayUnpaid	= 'Due';
	public $fmOrderPayNoItem	= 'Not Payment Made';
	public $fmOrderPayDuplicate	= 'Payment method exists';
	public $fmOrderBCTitle		= 'Barcode';
	public $fmOrderBCHint		= 'Ready to Scan Barcode';
	public $fmOrderBCError		= 'Error';
	public $fmOrderInvoiceOk	= 'Invoice OK';
	public $fmOrderInvoiceErr	= 'Invoice Error';
	public $fmOrderInvoiceDup	= 'Invoice exists';
	public $fmOrderConfirmDelete	= 'Do you really want to delete the complete order data?';
	
	// Order Query
	public $fmOrdMgtTitle		= 'Order Query';
	public $fmOrdMgtBtnBack		= 'Back';
	public $fmOrdMgtBtnView		= 'View';
	public $fmOrdMgtBtnComplete	= 'Complete';
	public $fmOrdMgtBtnPrint	= 'Print';
	public $fmOrdMgtBtnInvoice	= 'Invoice';
	public $fmOrdMgtCapId		= 'No.';
	public $fmOrdMgtCapKName	= 'Customer';
	public $fmOrdMgtCapPrice	= 'Price';
	public $fmOrdMgtCapStatus	= 'Completed(Y/N)';
	public $fmOrdMgtCapInvoice	= 'Invoice(Y/N)';
	public $fmOrdMgtMsg			= 'Please select one order';
	
	// Settings page
	public $fmSetTitle			= 'System Settings';
	public $fmSetBtnMyUser		= 'password';
	public $fmSetBtnCompany		= 'Company Profile';
	public $fmSetBtnUsers		= 'User Management';
	public $fmSetBtnLan			= 'Language';	
	public $fmSetBtnLogout 		= 'Log out';
	public $fmSetBtnSetsys 		= 'Settings';
	
	// Settings - Password page
	public $fmPwdTitle			= 'Change Password';
	public $fmPwdCapNew			= 'New Password';
	public $fmPwdCapRe			= 'Re-Type';
	public $fmPwdBtnBack		= 'Back';
	public $fmPwdBtnSave		= 'Save';
	public $fmPwdMsgPwd			= 'Please input new password';
	public $fmPwdMsgRePwd		= 'Please re-type new password';
	public $fmPwdMsgPwdNotMatch	= 'Password input & re-type not match!';
	
	// Settings - Language page
	public $fmLanTitle			= 'Language Settings';
	public $fmLanCap			= 'Language';
	public $fmLanBtnBack		= 'Back';
	public $fmLanBtnSave		= 'Save';

	// Settings - Company page
	public $fmCompTitle			= 'Company Profile';
	public $fmCompBtnBack		= 'Back';
	public $fmCompBtnSave		= 'Save';
	public $fmCompCap			= array("Name","Address","Post","City","Country","Tel","Fax","Mobile","E-Mail","WhatsApp","Tax ID","UID Nr.","IBAN","BIC","Tax","Website");
	
	// Settings - User page
	public $fmUserTitle			= 'Add User';
	public $fmUserCapName		= 'User Name';
	public $fmUserCapPwd		= 'Password';
	public $fmUserCapPwdRe		= 'Re-Type';
	public $fmUserBtnBack		= 'Back';
	public $fmUserBtnSave		= 'Save';
	public $fmUserMsgUser		= 'Please input user name';
	public $fmUserMsgPwd		= 'Please input password';
	public $fmUserMsgPwdRe		= 'Please re-type password';
	public $fmUserMsgPwdNotMatch= 'Password input & re-type not match!';
	public $fmUserMsgUserExist	= 'User already exists!';
	
	// customer list
	public $fmCustsTitle		= 'Customers';
	public $fmCustsBtnBack		= 'Back';
	public $fmCustsBtnView		= 'View';
	public $fmCustsBtnNew		= 'New';
	public $fmCustsCapId		= 'ID';
	public $fmCustsCapName		= 'Name';
	public $fmCustsCap1			= 'Orders';
	public $fmCustsCap2			= 'Value';

	// customer view
	public $fmCusTitle			= 'Customer';
	public $fmCusSubTitle		= 'New Customer';
	public $fmCusBtnBack		= 'Back';
	public $fmCusBtnSave		= 'Save';
	public $fmCusCapId			= 'ID';
	public $fmCusCapName		= 'Name';
	public $fmCusCap1			= 'Full Name';
	public $fmCusCap2			= 'Address';
	public $fmCusCap3			= 'Post';
	public $fmCusCap4			= 'City';
	public $fmCusCap5			= 'Country';
	public $fmCusCap6			= 'Tel';
	public $fmCusCap7			= 'Contact Person';
	
	// Help page
	public $fmHelpTitle			= 'Quick Help';
	
	// Contact page
	public $fmContactTitle		= 'Contact';
	
	// Messages
	public $msgInputNotNull		= 'Please fill in required field.';
	public $msgPageExpired		= 'Page expired';
	public $msgDatabaseError	= 'Database error';
	public $msgNoGetPara		= 'Get request with NO parameter.';
	public $msgNoRecordFound	= 'No record found';

	// sal_customers.php
	public $fmCustListTitle		= 'Customer List';
	public $fmCustListTitleSub	= 'Customer List';
	public $fmCustListBtnBack	= 'Back';
	public $fmCustListBtnView	= 'View';
	public $fmCustListBtnNew	= 'New';
	public $fmCustListCapId		= 'ID';
	public $fmCustListCapName	= 'Name';
	public $fmCustListCap1		= 'City';
	public $fmCustListCap2		= 'WhatsApp';
	
	// cust_search.php
	public $fmCustSrchTitle		= 'Search Customer';
	public $fmCustSrchMsgChoose	= 'Please select one customer';
	public $fmCustSrchMsgNoFound= 'No customer found';
	public $fmCustSrchCapId		= 'ID';
	public $fmCustSrchCapName	= 'Name';
	public $fmCustSrchCapName1	= 'Name1';
	public $fmCustSrchCapPost	= 'Post';
	public $fmCustSrchCapUst	= 'Ust-IdNr.';	
	public $fmCustSrchCapCity	= 'City';
	public $fmCustSrchBtnNext	= 'Next';
	public $fmCustSrchBtnNew	= 'New';
			
	// customer.php
		public $fmCustTitle 			= "Customer";
		public $fmCustTabPro 			= "Profile";
		public $fmCustTabSal 			= "Sales";
		public $fmCustTabPay 			= "Payment";
		public $fmCustTab2 				= "Additional";
		public $fmCustCapId 			= "No.";
		public $fmCustCapName 			= "*Name";
		public $fmCustCapName1 			= "Name 1";
		public $fmCustCapAddr 			= "Address";
		public $fmCustCapPost 			= "Post";
		public $fmCustCapCity 			= "City";
		public $fmCustCapCountry 		= "Country";
		public $fmCustCapTel			= "Tel";
		public $fmCustCapContact 		= "Contact";
		public $fmCustCapWhatsApp 		= "WhatsApp";
		public $fmCustCapWeChat			= "WeChat";
		public $fmCustCapDiscount		= "Discount";
		public $fmCustCapTaxNo			= "Tax. No.";
		public $fmCustCapUstNo			= "USt. No.";
		public $fmCustCapEmail			= "E-Mail";
		public $fmCustCapthId			= "Order#";
		public $fmCustCapthDate			= "Date";
		public $fmCustCapthPrice		= "Amount";
		public $fmCustCapthUnpaid		= "Unpaid";
		public $fmCustCapPSumOrders		= "Total Unpaid Orders";
		public $fmCustCapPSumPrice		= "Total Price";
		public $fmCustCapPSumUnpaid		= "Total Unpaid";
		public $fmCustCapStSumOrders	= "Total Orders:  ";
		public $fmCustCapStSumCount		= "  Total Articles:  ";
		public $fmCustCapStSumPrice		= "  Total Sales:  ";
		public $fmCustCapthSales		= "Sales";
		public $fmCustCapthCount		= "Articles";
		public $fmCustBtnStSelTime		= "Choose Time";
		public $fmCustBtnSave			= "Save";
		public $fmCustBtnClose			= "Close";
		public $fmCustAutoCode		= "Auto";
		public $fmCustInputCode		= "Edit";
			
		// modalTime
		public $mdTimeTitle 		= "Time Selection";
		public $mdTimeRdAll 		= "All";
		public $mdTimeRdDay 		= "On Day";
		public $mdTimeRdWeek 		= "One week";
		public $mdTimeRdMonth 		= "One Month";
		public $mdTimeRd3Months 	= "Three Months";
		public $mdTimeRdYear 		= "One Year";
		
		// modalOrder
		public $mdOrderTitle = "Bestellung Nr.: ";
		public $mdOrderThCode = "Artikel Nr.";
		public $mdOrderThName = "Bezeichnung";
		public $mdOrderThCount = "Anzahl";
		public $mdOrderThPrice = "Nettobetrag";
		public $mdOrderSumCount = "Gesamtmenge:  ";
		public $mdOrderSumPrice = "  Total: ";
		
		// modalSelTime
		public $mdstTitle 			= "Time Selection";
		public $mdstRdAll 			= "All";
		public $mdstRdToday 		= "Today";
		public $mdstRdYesterday 	= "Yesterday";
		public $mdstRdThisMonth 	= "This Month";
		public $mdstRdLastMonth 	= "Last Month";
		public $mdstRdThisYear 		= "This Year";
		public $mdstRdLastYear 		= "Last Year";
		public $mdstYear 			= "Year";
		public $mdstMonth 			= "Month";
		public $mdstFrom 			= "From";
		public $mdstTo 				= "To";
		
		// Barcode
		public $bcTitle				= "EUCWS Barcode Printing";
		public $bcBack				= "Back";
		public $bcPurchase			= "Barcode from Purchase";
		public $bcProducts			= "Barcode from Products";
		public $bcEnterCode			= "Please enter Artikel No.";
		public $bcSettings			= "Settings";
		public $bcUpdate			= "Data Update";
		public $bcClear				= "Clear";
		public $bcCapCode			= "Artikel No.";
		public $bcCapUnits			= "Units";
		public $bcCapVariant		= "Variant";
		public $bcCapCount			= "Quantity";
		public $bcCapAmount			= "Quantity";
		public $bcCapBarcode		= "Barcode";
		public $bcCapCopy			= "Copies";
		public $bcPrint				= "Print";
		public $bcSetTitle			= "Barcode Options";
		public $bcSetBC				= "Print Barcode";
		public $bcSetCode			= "Print Artikel No.";
		public $bcSetVariant		= "Print Variant";
		public $bcListDate			= "Date";
		public $bcListPNo			= "No.";
		public $bcListSup			= "Supplier";
		public $bcListCount			= "Amount";
		public $bcListValue			= "Value";
		public $bcMsgUpdate			= "Update completed";
		public $bcPrintAll			= "Print All";
		public $bcPaperWidth		= "Paper Width";
		public $bcPaperHeight		= "Paper Height";
		public $bcCodeWidth			= "Barcode Width";
		public $bcCodeHeight		= "Barcode Height";
		public $bcFontSize			= "Font Size";
		public $bcColorSecond		= "Color at second row";
		
		// APP
		public $appMgtTitle			= "APP Product Management";
		public $appHomeNew			= "New Product";
		public $appHomeMgt			= "Product Management";
		public $appHomeTypes		= "Product Types";
		public $appHomePage			= "Page Management";
		public $appHomeUpdate		= "Data Update";
		
		public $appPdDel			= "Delete";
		public $appPdState			= "Status";
		public $appPdSave			= "Save";
		public $appPdArtNo			= "ART.";
		public $appPdType			= "Type";
		public $appPdCount			= "Amount";
		public $appPdPrice			= "Price";
		public $appPdOldPrice		= "Original";
		public $appPdIsHot			= "Hot";
		public $appPdIsNew			= "New";
		public $appPdNote			= "Note";
		public $appPdTextDrag		= "Drag&drop to change image position";
		public $appPdMdTypeTitle	= "New Type";
		public $appPdMdTypeName		= "Type Name";
		
		public $appMgtCapCode		= "Art#";
		public $appMgtCapStatus		= "Status";
		public $appMgtCapAppType	= "Sys Type";
		public $appMgtCapType		= "Type";
		
		public $appMgtSortCreateDesc	= "Created (latest)";
		public $appMgtSortCreateAsc		= "Created (oldest)";
		public $appMgtSortAZ		= "Code A-Z";
		public $appMgtSortZA		= "Code Z-A";
		public $appMgtColCode		= "ART#";
		public $appMgtColType		= "Type";
		public $appMgtColCount		= "Inventory";
		public $appMgtColPrice		= "Price";
		public $appMgtColAppType	= "Sys Types";
		public $appMgtColStatus		= "Status";
		public $appMgtNewTotal		= "Display";
		public $appMgtTotal			= "Total";
		
		public $appTypeAll			= "All";
		public $appTypeHot			= "Hot";
		public $appTypeNew			= "New";
		public $appTypeSale			= "On Sale";
		public $appTypeUnknown		= "Unknown";
		public $appTypeCommon		= "Common";
		
		public $appStatusAll		= "All";
		public $appStatusNormal		= "Normal";
		public $appStatusOffline	= "Off-line";
		public $appStatusRestock	= "Restocking";
		public $appMsgUpdateYes		= "Data Update OK!";
		public $appMsgUpdateNo		= "Data Update failed! Please try again later.";
		public $appMsgErrProductAdd	= "Failed to create product";
		public $appMsgErrProductUpdate	= "Failed to update product";
		
		// system
		public $sysMsgNoRecord			="No record found";
		public $msgErrLoadDb			="Load data error";
		public $msgErrNoData			="No data found";
		public $msgErrDataInput			="Invalid data";
		public $msgErrNoEnoughStock		="No enough stock";
		public $msgErrDupProduct		="Product exists";
		public $msgErrDupID				="ID exists";
		public $msgErrDupData			="Data exists";
		public $msgErrProductNoExist	="Product not found";
		public $msgConfirmSave			="Do you want to save the data?";
		public $msgConfirmDelete		="Do you really want to delete the data?";
		public $msgErrDatabase			="System error. Please try later.";
		public $msgErrNoRecord			="No data";
		public $msgErrNoCustomer		="Please enter customer data.";
		public $msgDataNotComplete		="Data not completed. Please save or print, or delete.";
		
		public $txtUnitOne		="";
		public $txtUnitMore		="";
		
		// common		
		public $comCustomer 	= "Customer";
		public $comCustomerAll 	= "All Customers";
		public $comCustomerUnknown 	= "Unknown Customer";
		public $comDiscount	 	= "Discount";
		public $comDue		 	= "Due";
		public $comFee		 	= "Fees";
		public $comFileExport	= "File Export";
		public $comInvoice 		= "Invoice";
		public $comInvoiceNo 	= "Invoice No.";
		public $comItem 		= "Item";
		public $comListRefund 	= "Refund List";		
		public $comOptions	 	= "Options";
		public $comPaid		 	= "Paid";
		public $comPayment	 	= "Payment";
		public $comPrice	 	= "Price";
		public $comProductName 	= "Name";
		public $comProductNo 	= "Art. No.";
		public $comQuantity 	= "Quantity";		
		public $comRefundNo 	= "Refund No.";
		public $comRefundTime 	= "Time Refund";
		public $comSubtotal 	= "Subtotal";
		public $comTax		 	= "Tax";
		public $comTotalGross 	= "TTL. Price";
		public $comTotalNet 	= "Net";
		public $comTotalPrice 	= "Gross";
		public $comTotalQuantity = "TTL. Quantity";
		public $comTotalRecord 	= "Total Records";
		public $comVat 			= "VAT";
		
		// options
		public $opDecimalNormal	= "Use dot as decimal";
		public $opDecimalComma	= "Use comma as decimal";
		
	public function __construct($language)
	{
		if(strcmp($language, 'cn')==0)
		{
			// Navigation
			$this->nvHome			= '主页';
			$this->nvInventory 		= '库存';
			$this->nvPurchase 		= '进货';
			$this->nvSales			= '销售';
			$this->nvReports		= '统计';
			$this->nvManagement	= '管理';
			$this->nvSettings		= '设置';
			$this->nvHelp			= '帮助';
			$this->nvHelpHelp		= '快捷帮助';
			$this->nvHelpContact	= '客户支持';
	
			// home.php
			$this->fmHomeTitle	= '常用功能';
			$this->fmHomeBtn1 	= '新的订单';
			$this->fmHomeBtn2 	= '新的进货';
			$this->fmHomeBtn3 	= '库存列表';
			$this->fmHomeBtn4 	= '管理功能';
			$this->fmHomeBtn5 	= '统计功能';
			$this->fmHomeBtn6 	= '系统设置';
			$this->fmHomeBtn7 	= '添加商品';
			$this->fmHomeBtn8 	= '';
			
			// inv.php
			$this->fmInvTitle		= '库存管理';
			$this->fmInvTitleMsg1	= '当前库存: 模特';
			$this->fmInvTitleMsg2	= ';  服装';
			$this->fmInvTitleMsg3	= ';  总计';
			$this->fmInvTitleMsg4	= '欧元';
			$this->fmInvBtn1		= '初始库存';
			$this->fmInvBtn2		= '库存管理';
			$this->fmInvBtn3		= '厂家管理';
			$this->fmInvBtn4		= '商品分类';
			$this->fmInvBtn5		= '进货单';
			$this->fmInvBtn6		= '';

			// inv_search.php
			$this->fmInvSrchTitle		= '查找商品';
			$this->fmInvSrchMsgBefore	= '请输入货号来查找商品';
			$this->fmInvSrchMsgYes		= '已找到下列符合条件的商品.';
			$this->fmInvSrchMsgNo		= '未能找到符合条件的商品.';
			$this->fmInvSrchMsgChoose	= '请选择一个商品.';
			$this->fmInvSrchCapCode		= '货号';
			$this->fmInvSrchCapId		= '编号';
			$this->fmInvSrchCapImage	= '照片';
			$this->fmInvSrchCapData		= '信息';
			$this->fmInvSrchCapCount	= '库存';	
			$this->fmInvSrchCapCost		= '成本';
			$this->fmInvSrchBtnSearch	= '查找';
			$this->fmInvSrchBtnBack		= '取消';
			$this->fmInvSrchBtnShow		= '查看商品';
			$this->fmInvSrchBtnNew		= '创建新的商品';
			
			// inv_view.php
			$this->fmInvNewTitle		= '库存商品';
			$this->fmInvNewTitleNew		= '全新商品';
			$this->fmInvNewBtnBack		= '返回';
			$this->fmInvNewBtnSave		= '保存';
			$this->fmInvNewBtnPrint		= '条码';
			$this->fmInvNewBtnPhoto		= '拍照';
			$this->fmInvNewBtnLog		= '明细';
			$this->fmInvNewBtnAdd		= '添加库存';
			$this->fmInvNewBtnEdit		= '修改库存';
			$this->fmInvNewBtnMDel		= '删除';
			$this->fmInvNewBtnMClose	= '关闭';
			$this->fmInvNewCapId		= '系统编号';
			$this->fmInvNewCapCode		= '货号 *';
			$this->fmInvNewCapName		= '名称';
			$this->fmInvNewCapVariant	= '款色';
			$this->fmInvNewCapCode1		= '其他编号1';
			$this->fmInvNewCapCode1		= '其他编号2';
			$this->fmInvNewCapType		= '分类 *';
			$this->fmInvNewCapSup		= '厂家';
			$this->fmInvNewCapCost		= '进价 *';
			$this->fmInvNewCapPrice		= '售价 *';
			$this->fmInvNewCapCountNew	= '*新增库存';	
			$this->fmInvNewCapCount		= '库存 *';
			$this->fmInvNewCapCountA	= '*可售';			
			$this->fmInvNewCapNote		= '备注';
			$this->fmInvNewCapBarcode	= '条码';
			$this->fmInvNewCapDisc		= '折扣价';
			$this->fmInvNewCapHTitle	= '商品历史记录';
			$this->fmInvNewCapHTime		= '时间';
			$this->fmInvNewCapHAmount	= '件数';
			$this->fmInvNewCapHCost		= '成本';
			$this->fmInvNewCapHSource	= '来源';
			$this->fmInvNewCapATitle	= '添加库存';
			$this->fmInvNewCapACount	= '数量';
			$this->fmInvNewCapACost		= '进价';
			$this->fmInvNewCapETitle	= '修改库存';
			$this->fmInvNewCapECount	= '库存';
			$this->fmInvNewCapECost		= '成本';
			$this->fmInvNewMsgEdit		= '确定要修改库存吗?';
			$this->fmInvNewCapPos		= '位置';
			$this->fmInvNewCapColor		= '颜色';
			$this->fmInvNewSupTitle		= '新增厂家';
			$this->fmInvNewSupID		= '厂家编码 *';
			$this->fmInvNewSupName		= '厂家名称 *';
			$this->fmInvNewTypeTitle	= '新增类别';
			$this->fmInvNewTypename		= '类别名称 *';
			$this->fmInvNewUnitTitle	= '包装配比';
			$this->fmInvNewUnitType		= '包装单位';
			$this->fmInvNewUnitQty		= '包装件数';
			$this->fmInvNewUnitNew		= '新增配比';
			$this->fmInvNewUnitChoose	= '选择件数';
			$this->fmInvNewVarAdd		= '添加款色';
			$this->fmInvNewVarName		= '款色';
			$this->fmInvNewVarCount		= '数量';
			$this->fmInvNewVarBarcode	= '条码';
			$this->fmInvNewVarNum		= '款色数:';
			$this->fmInvNewVarTotal		= '总件数:';
			$this->fmInvNewVarNew		= '新的款色';
			$this->fmInvNewVarEdit		= '编辑款色';	
			// inv_mgt.php
			$this->fmInvMgtTitle		= '库存管理';
			$this->fmInvMgtCapCode		= '货号查询';
			$this->fmInvMgtCapImage		= '照片';
			$this->fmInvMgtCapData		= '信息';
			$this->fmInvMgtCapCount		= '库存';
			$this->fmInvMgtCapCost		= '金额';
			$this->fmInvMgtTime			= '时间';
			$this->fmInvMgtSort			= '排序';
			$this->fmInvMgtSUpdated		= '最近更新';
			$this->fmInvMgtSCreated		= '最新创建';
			$this->fmInvMgtSCodeAZ		= '货号A-Z';
			$this->fmInvMgtSCodeZA		= '货号Z-A';
			$this->fmInvMgtSCountDesc	= '库存最多';
			$this->fmInvMgtSCountAsc	= '库存最少';
			$this->fmInvMgtSCostDesc	= '金额最大';
			$this->fmInvMgtSCostAsc		= '金额最小';
			$this->fmInvMgtCapCountT	= '总库存:';
			$this->fmInvMgtCapCostT		= '总金额:';
			$this->fmInvMgtCapAllT		= '模特数:';
			$this->fmInvMgtFSupAll		= '全部厂家';
			$this->fmInvMgtFSupX		= '未知厂家';
			$this->fmInvMgtFTypeAll		= '全部类别';
			$this->fmInvMgtFTypeX		= '未分类';
			$this->fmInvMgtBtnNew		= '新增商品';
			
			// Inventory statistics
			$this->fmInvStatTitle 		= '库存统计';
			$this->fmInvStatBtnBack 	= '返回';
			$this->fmInvStatCapSName 	= '供应商';
			$this->fmInvStatCapSCount 	= '模特数';
			$this->fmInvStatCapTName 	= '商品类别';
			$this->fmInvStatCapTCount 	= '模特数';
			$this->fmInvStatTabSup 		= '按供应商统计';
			$this->fmInvStatTabType 	= '按商品类别统计';
	
			// purchase.php
			$this->fmPurTitle			= '批量入库';
			$this->fmPurBtnBack			= '关闭';
			$this->fmPurCapId			= '编号';
			$this->fmPurCapPurId		= '单号';
			$this->fmPurCapHId			= '编号';
			$this->fmPurCapHSpId		= '单号';
			$this->fmPurCapHSpDate		= '到货时间';
			$this->fmPurCapHSName		= '供货商';
			$this->fmPurCapHNote		= '说明';
			$this->fmPurCapItem			= '信息';
			$this->fmPurCapAmount		= '数量';
			$this->fmPurCapCost			= '进价';
			$this->fmPurTitleModal		= '到货信息';
			$this->fmPurBtnModalClose	= '关闭';
			$this->fmPurMsgDel			= '确定删除此项入库操作?';
			
			// Purchase Management
			$this->fmPurMgtTitle		= '进货单管理';
			$this->fmPurMgtCapCId		= '编号';
			$this->fmPurMgtCapCSPId		= '进货单号';
			$this->fmPurMgtCapCDate		= '时间';
			$this->fmPurMgtCapCName		= '供应商';
			$this->fmPurMgtCapCTotal	= '总价';
			$this->fmPurMgtCapCStatus	= '状态';
			$this->fmPurMgtBtnBack		= '关闭';
			$this->fmPurMgtBtnAll		= '全部进货';
			$this->fmPurMgtBtnView		= '查看';
	
			// inv_types.php
			$this->fmTypesTitle			= '商品类别管理';
			$this->fmTypesTitleSub		= '点击类别进行修改';
			$this->fmTypesTitleEdit		= '修改商品类别';
			$this->fmTypesTitleAdd		= '新增商品类别';
			$this->fmTypesBtnBack		= '关闭';
			$this->fmTypesBtnEdit		= '修改';
			$this->fmTypesBtnAdd		= '增加';
			$this->fmTypesBtnCancel		= '取消';
			$this->fmTypesBtnNew		= '新增类别';
			$this->fmTypesCapId			= '类别编号';
			$this->fmTypesCapName		= '类别名称';
			
			// inv_suppliers.php
			$this->fmSupsTitle			= '供应商管理';
			$this->fmSupsTitleSub		= '点击厂家以查看';
			$this->fmSupsBtnBack		= '关闭';
			$this->fmSupsBtnView		= '查看';
			$this->fmSupsBtnNew			= '新增厂家';
			$this->fmSupsCapId			= '编号';
			$this->fmSupsCapName		= '名称';
			$this->fmSupsCapTel			= '电话';
			$this->fmSupsCapContact		= '联系人';
			$this->fmSupsMsg			= '请选择一个供应商';
			
			// supplier.php
			$this->fmSupVTitle			= '供应商资料';
			$this->fmSupVBtnBack		= '返回';
			$this->fmSupVBtnSave		= '保存';
			$this->fmSupVCapId			= '编号';
			$this->fmSupVCapName		= '*名称';
			$this->fmSupVCapTel			= '电话';
			$this->fmSupVCapAddr		= '地址';
			$this->fmSupVCapPost		= '邮编';
			$this->fmSupVCapCity		= '城市';
			$this->fmSupVCapCountry		= '国家';
			$this->fmSupVCapContact		= '联系人';
			$this->fmSupVCapEmail		= 'E-Mail';
			
			// sales.php
			$this->fmSalTitle		= '销售管理';
			$this->fmSalBtn1		= '新的订单';
			$this->fmSalBtn2		= '订单列表';
			$this->fmSalBtn3		= '客户管理';
			$this->fmSalBtn4		= '销售统计';
			$this->fmSalBtn5		= '';
			$this->fmSalBtn6		= '';

			// Order page
			$this->fmOrderBtnInvoice	= '发票';
			$this->fmOrderCapPhoto		= '';
			$this->fmOrderCapItem		= '货号';
			$this->fmOrderCapCount		= '件数';
			$this->fmOrderCapPrice		= '价格';
			$this->fmOrderCapSubtotal	= '小计';
			$this->fmOrderTotalNum		= '总件数:';
			$this->fmOrderTotal			= '总金额:';
			$this->fmOrderNet			= '净金额:';
			$this->fmOrderPaid			= '已付:';
			$this->fmOrderUnpaid		= '未付:';
			$this->fmOrderTableEmpty	= '请按“+”添加商品';
			$this->fmOrderSrchTitle		= '输入货号查找商品';
			$this->fmOrderSrchArt		= '货号';
			$this->fmOrderItemTitle		= '订单项目';
			$this->fmOrderItemArt		= '货号';
			$this->fmOrderItemName		= '名称';
			$this->fmOrderItemUnit		= '单位';
			$this->fmOrderItemStock		= '库存';
			$this->fmOrderItemCount		= '件数';
			$this->fmOrderItemVar		= '款色';
			$this->fmOrderItemPrice		= '价格';
			$this->fmOrderDisTitle		= '折扣';
			$this->fmOrderDisRate		= '折扣 (%)';
			$this->fmOrderDisValue		= '金额';
			$this->fmOrderFeeTitle		= '费用';
			$this->fmOrderFeeShipping	= '运费';
			$this->fmOrderFeeBank		= '银行费用';
			$this->fmOrderFeeNach		= 'Nachnahme';
			$this->fmOrderFeeOther		= '其他费用';
			$this->fmOrderPayTitle		= '付款';
			$this->fmOrderPayAmount		= '待付金额';
			$this->fmOrderPayMethod		= '方式';
			$this->fmOrderPayValue		= '金额';
			$this->fmOrderPayTotal		= '应付';
			$this->fmOrderPayPaid		= '已付';
			$this->fmOrderPayUnpaid		= '未付';
			$this->fmOrderPayNoItem		= '没有付款条目';
			$this->fmOrderPayDuplicate	= '付款方式已存在';
			$this->fmOrderBCTitle		= '扫码输入商品';
			$this->fmOrderBCHint		= '请扫描条码';
			$this->fmOrderBCError		= '条码错误';
			$this->fmOrderInvoiceOk		= '发票成功';
			$this->fmOrderInvoiceErr	= '发票错误';
			$this->fmOrderInvoiceDup	= '该订单已开过发票，不能重复';
			$this->fmOrderConfirmDelete	= '删除该订单将导致所有相关的订货信息被删除。确认删除?';
			
			// Order Query
			$this->fmOrdMgtTitle		= '订单查询';
			$this->fmOrdMgtBtnBack		= '返回';
			$this->fmOrdMgtBtnView		= '查看';
			$this->fmOrdMgtBtnComplete	= '订单确认';
			$this->fmOrdMgtBtnPrint		= '打印订单';
			$this->fmOrdMgtBtnInvoice	= '转发票';
			$this->fmOrdMgtCapId		= '订单号';
			$this->fmOrdMgtCapKName		= '客户';
			$this->fmOrdMgtCapPrice		= '价值';
			$this->fmOrdMgtCapStatus	= '状态';
			$this->fmOrdMgtCapInvoice	= '发票';	
			$this->fmOrdMgtMsg			= '请选择一个订单';
			
			// Settings page
			$this->fmSetTitle			= '系统设置';
			$this->fmSetBtnMyUser		= '密码修改';
			$this->fmSetBtnCompany		= '公司资料';
			$this->fmSetBtnUsers		= '用户管理';
			$this->fmSetBtnLan			= '语言设置';
			$this->fmSetBtnLogout		= '退出系统';
			$this->fmSetBtnSetsys		= '系统选项';
			
			// Settings - Password page
			$this->fmPwdTitle			= '密码修改';
			$this->fmPwdCapNew			= '新的密码';
			$this->fmPwdCapRe			= '再次输入';
			$this->fmPwdBtnBack			= '取消';
			$this->fmPwdBtnSave			= '保存';
			$this->fmPwdMsgPwd			= '请输入新的密码';
			$this->fmPwdMsgRePwd		= '请再次输入新的密码';
			$this->fmPwdMsgPwdNotMatch	= '两次输入的密码不一致，请重新输入';
			
			// Settings - Language page
			$this->fmLanTitle			= '语言设置';
			$this->fmLanCap				= '语言选择';
			$this->fmLanBtnBack			= '返回';
			$this->fmLanBtnSave			= '保存';
			
			// Settings - Company page
			$this->fmCompTitle			= '公司资料';
			$this->fmCompBtnBack		= '返回';
			$this->fmCompBtnSave		= '保存';
			$this->fmCompCap			= array("名称","地址","邮编","城市","国家","电话","传真","手机","E-Mail","WhatsApp","Steuer Nr.","USt-IdNr.","IBAN","BIC","税率","网址");
	
			// Settings - User page
			$this->fmUserTitle			= '添加用户';
			$this->fmUserCapName		= '用户名';
			$this->fmUserCapPwd			= '输入用户密码';
			$this->fmUserCapPwdRe		= '再次输入密码';
			$this->fmUserBtnBack		= '返回';
			$this->fmUserBtnSave		= '保存';
			$this->fmUserMsgUser		= '请输入用户名';
			$this->fmUserMsgPwd			= '请输入密码';
			$this->fmUserMsgPwdRe		= '请再次输入密码';
			$this->fmUserMsgPwdNotMatch	= '两次输入的密码不一致，请重新输入!';
			$this->fmUserMsgUserExist	= '该用户已存在!';
	
			// Help page
			$this->fmHelpTitle			= '快捷帮助';
	
			// Contact page
			$this->fmContactTitle		= '客户支持信息';
			
			// Messages
			$this->msgInputNotNull		= '此项不能为空';
			$this->msgPageExpired		= '您访问的页面已失效';
			$this->msgDatabaseError		= '数据库访问出现问题，请稍后再试';
			$this->msgNoGetPara			= '访问的页面缺少参数:';
			$this->msgNoRecordFound		= '没有找到符合条件的记录';
			
			// cust_list.php
			$this->fmCustListTitle		= '客户管理';
			$this->fmCustListTitleSub	= '点击客户以查看或修改';
			$this->fmCustListBtnBack	= '返回';
			$this->fmCustListBtnView	= '查看';
			$this->fmCustListBtnNew		= '新增';
			$this->fmCustListCapId		= '编号';
			$this->fmCustListCapName	= '名称';
			$this->fmCustListCap1		= '城市';
			$this->fmCustListCap2		= 'WhatsApp';

			// cust_search.php
			$this->fmCustSrchTitle		= '选择客户';
			$this->fmCustSrchMsgChoose	= '请选择一个客户';
			$this->fmCustSrchMsgNoFound	= '没有找到符合条件的客户';
			$this->fmCustSrchCapId		= '编号';
			$this->fmCustSrchCapName	= '名称';
			$this->fmCustSrchCapName1	= '别名';
			$this->fmCustSrchCapPost	= '邮编';
			$this->fmCustSrchCapUst		= 'Ust-IdNr.';	
			$this->fmCustSrchCapAddr	= '地址';
			$this->fmCustSrchBtnNext	= '下一步';
			$this->fmCustSrchBtnNew		= '创建新的客户';
			
			// customer.php
			$this->fmCustTitle 			= "客户: ";
			$this->fmCustTabPro 		= "基本资料";
			$this->fmCustTabSal 		= "销售统计";
			$this->fmCustTabPay 		= "收款状态";
			$this->fmCustTab2 			= "其他信息";
			$this->fmCustCapId 			= "*编号";
			$this->fmCustCapName 		= "*名称";
			$this->fmCustCapName1 		= "其他名称";
			$this->fmCustCapAddr 		= "地址";
			$this->fmCustCapPost 		= "邮编";
			$this->fmCustCapCity 		= "城市";
			$this->fmCustCapCountry 	= "国家";
			$this->fmCustCapTel			= "电话";
			$this->fmCustCapContact 	= "联系人";
			$this->fmCustCapWhatsApp 	= "WhatsApp";
			$this->fmCustCapWeChat		= "微信号";
			$this->fmCustCapDiscount	= "折扣";
			$this->fmCustCapTaxNo		= "税号";
			$this->fmCustCapUstNo		= "USt-IdNo.";
			$this->fmCustCapEmail		= "E-Mail";
			$this->fmCustCapthId		= "订单号";
			$this->fmCustCapthDate		= "日期";
			$this->fmCustCapthPrice		= "应收";
			$this->fmCustCapthUnpaid	= "未收";
			$this->fmCustCapPSumOrders	= "欠款订单数:  ";
			$this->fmCustCapPSumPrice	= "  总应收:  ";
			$this->fmCustCapPSumUnpaid	= "  总未收:  ";
			$this->fmCustCapStSumOrders	= "总订单数:  ";
			$this->fmCustCapStSumCount	= "  总销售件数:  ";
			$this->fmCustCapStSumPrice	= "  总销售额:  ";
			$this->fmCustCapthSales		= "金额";
			$this->fmCustCapthCount		= "件数";
			$this->fmCustBtnStSelTime	= "选择时间段";
			$this->fmCustBtnStItems		= "销售总表";
			$this->fmCustBtnSave		= "保存";
			$this->fmCustBtnClose		= "返回";
			$this->fmCustAutoCode		= "自动";
			$this->fmCustInputCode		= "编辑";
			
			// modalTime
			$this->mdTimeTitle 			= "时间筛选";
			$this->mdTimeRdAll 			= "全部时间";
			$this->mdTimeRdDay 			= "当天数据";
			$this->mdTimeRdWeek 		= "最近一周";
			$this->mdTimeRdMonth 		= "最近一月";
			$this->mdTimeRd3Months 		= "最近三月";
			$this->mdTimeRdYear 		= "最近一年";
			
			// modalOrder
			$this->mdOrderTitle = "订单号: ";
			$this->mdOrderThCode = "货号";
			$this->mdOrderThName = "名称";
			$this->mdOrderThCount = "件数";
			$this->mdOrderThPrice = "售价";
			$this->mdOrderSumCount = "总件数:  ";
			$this->mdOrderSumPrice = "  总金额:  ";	
			
			// modalItems
			$this->mdItemsTitle = "销售总表";
			$this->mdItemsThCode = "货号";
			$this->mdItemsThName = "名称";
			$this->mdItemsThCount = "件数";
			$this->mdItemsThPrice = "金额";
			$this->mdItemsSumCount = "总件数:  ";
			$this->mdItemsSumPrice = "  总金额:  ";	
			
			// modalSelTime
			$this->mdstTitle 			= "选择时间";
			$this->mdstRdAll 			= "所有时间";
			$this->mdstRdToday 			= "今天";
			$this->mdstRdYesterday 		= "昨天";
			$this->mdstRdThisMonth 		= "本月";
			$this->mdstRdLastMonth 		= "上月";
			$this->mdstRdThisYear 		= "今年";
			$this->mdstRdLastYear 		= "去年";
			$this->mdstYear 			= "年";
			$this->mdstMonth 			= "月";
			$this->mdstFrom 			= "起";
			$this->mdstTo 				= "至";
			
			// Barcode
			$this->bcTitle				= "EUCWS条码打印系统";
			$this->bcBack				= "返回";
			$this->bcPurchase			= "从进货单打印";
			$this->bcProducts			= "从库存打印";
			$this->bcEnterCode			= "请输入货号";
			$this->bcSettings			= "条码设置";
			$this->bcUpdate				= "数据更新";
			$this->bcClear				= "重新输入";
			$this->bcCapCode			= "货号";
			$this->bcCapUnits			= "单位";
			$this->bcCapVariant			= "款色";
			$this->bcCapCount			= "库存";
			$this->bcCapAmount			= "数量";
			$this->bcCapBarcode			= "条码";
			$this->bcCapCopy			= "打印数量";
			$this->bcPrint				= "打印";
			$this->bcSetTitle			= "条码打印选项";
			$this->bcSetBC				= "打印条码";
			$this->bcSetCode			= "打印货号";
			$this->bcSetVariant			= "打印款色";
			$this->bcListDate			= "日期";
			$this->bcListPNo			= "单号";
			$this->bcListSup			= "厂家";
			$this->bcListCount			= "件数";
			$this->bcListValue			= "金额";
			$this->bcMsgUpdate			= "数据更新完成!";
			$this->bcPrintAll			= "打印全部";
			$this->bcPaperWidth			= "打印纸宽度";
			$this->bcPaperHeight		= "打印纸高度";
			$this->bcCodeWidth			= "条码宽度";
			$this->bcCodeHeight			= "条码高度";
			$this->bcFontSize			= "字符大小";
			$this->bcColorSecond		= "款色打印在第二行";
			
			// APP
			$this->appMgtTitle			= "APP商品管理";
			$this->appHomeNew			= "商品上架";
			$this->appHomeMgt			= "商品管理";
			$this->appHomeTypes			= "商品分类";
			$this->appHomePage			= "页面管理";
			$this->appHomeUpdate		= "数据更新";
			
			$this->appPdDel				= "删除";
			$this->appPdState			= "状态";
			$this->appPdSave			= "保存";
			$this->appPdArtNo			= "货号";
			$this->appPdType			= "类别";
			$this->appPdCount			= "库存";
			$this->appPdPrice			= "售价";
			$this->appPdOldPrice		= "原价";
			$this->appPdIsHot			= "热卖";
			$this->appPdIsNew			= "新货";
			$this->appPdNote			= "描述";
			$this->appPdTextDrag		= "拖动图片来改变图片位置";	
			$this->appPdMdTypeTitle		= "新增类别";
			$this->appPdMdTypeName		= "类别名称";
			
			$this->appMgtCapCode		= "货号";
			$this->appMgtCapStatus		= "状态";
			$this->appMgtCapAppType		= "系统类别";
			$this->appMgtCapType		= "自定义类别";
			$this->appMgtSortCreateDesc	= "最新创建优先";
			$this->appMgtSortCreateAsc	= "最早创建优先";
			$this->appMgtSortAZ			= "货号A-Z";
			$this->appMgtSortZA			= "货号Z-A";
			$this->appMgtColCode		= "货号";
			$this->appMgtColType		= "类别";
			$this->appMgtColCount		= "库存";
			$this->appMgtColPrice		= "售价";
			$this->appMgtColAppType		= "系统类别";
			$this->appMgtColStatus		= "状态";
			$this->appMgtNewTotal		= "显示";
			$this->appMgtTotal			= "总计";
			
			$this->appTypeAll			= "全部";
			$this->appTypeHot			= "热卖";
			$this->appTypeNew			= "新货";
			$this->appTypeSale			= "折扣";
			$this->appTypeUnknown		= "未分类";
			$this->appTypeCommon		= "一般";
			
			$this->appStatusAll			= "全部";
			$this->appStatusNormal		= "正常";
			$this->appStatusOffline		= "下架";
			$this->appStatusRestock		= "补货";
			$this->appMsgUpdateYes		= "数据更新成功";
			$this->appMsgUpdateNo		= "数据更新失败, 请稍后再试";
			$this->appMsgErrProductAdd	= "创建新的商品出现错误";
			$this->appMsgErrProductUpdate	= "保存商品出现错误";
			
			// system
			$this->sysMsgNoRecord		="没有符合条件的数据";
			$this->msgErrLoadDb			="读取数据错误";
			$this->msgErrNoData			="没有数据";
			$this->msgErrDataInput		="数据有误";
			$this->msgErrNoEnoughStock	="库存不足";
			$this->msgErrDupProduct		="商品不能重复";
			$this->msgErrDupID			="编号已存在";
			$this->msgErrDupData		="数据已存在";
			$this->msgErrProductNoExist	="没有找到该商品";
			$this->msgConfirmSave		="确认保存?";
			$this->msgConfirmDelete		="确认删除?";
			
			$this->txtUnitOne		="件";
			$this->txtUnitMore		="包";
			
		}
    }

}
	
?>
