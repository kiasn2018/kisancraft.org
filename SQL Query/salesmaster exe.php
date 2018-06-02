UPDATE sales
INNER
  JOIN Excutivemst
    ON sales.District = Excutivemst.District 
   SET sales.Executive = Excutivemst.Exexutive,sales.EID = Excutivemst.EID,sales.ASM = Excutivemst.ASM,sales.AID = Excutivemst.AID,sales.SM = Excutivemst.SM,sales.SID = Excutivemst.SID,sales.ZM = Excutivemst.ZM,sales.ZID = Excutivemst.ZID
   
   
   UPDATE sales
INNER
  JOIN Itemmst
    ON sales.Product = Itemmst.Item_name
   SET sales.SKU = Itemmst.SKU,sales.SKU1 = Itemmst.SKU1
   
    UPDATE sales
INNER
  JOIN SKU       
    ON sales.SKU = SKU.SKU
   SET sales.seqment = SKU.segment
   
   Select sales.amount,salesmaster.amount
INNER
  JOIN Dealermst
    ON sales.State = Dealermst.D_state,salesmaster.State = Dealermst.D_state
   
   
   UPDATE sales
INNER
  JOIN Dealermst
    ON sales.Dealer = Dealermst.D_name
   SET sales.state = Dealermst.D_state,sales.District = Dealermst.D_distict
   
   SELECT DISTINCT SKU FROM `sales` where SKU!='' and Seqment=''
   
   UPDATE sales
INNER
  JOIN Zonesmst
    ON sales.District = Zonesmst.District and sales.State=Zonesmst.State 
   SET sales.Zone = Zonesmst.Zone
   
   UPDATE sales INNER JOIN supersegment ON sales.Seqment = supersegment.segment SET sales.supersegment = supersegment.supersegment