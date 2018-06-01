UPDATE Salesmaster
INNER
  JOIN Excutivemst
    ON Salesmaster.District = Excutivemst.District 
   SET Salesmaster.Executive = Excutivemst.Exexutive,Salesmaster.EID = Excutivemst.EID,Salesmaster.ASM = Excutivemst.ASM,Salesmaster.AID = Excutivemst.AID,Salesmaster.SM = Excutivemst.SM,Salesmaster.SID = Excutivemst.SID,Salesmaster.ZM = Excutivemst.ZM,Salesmaster.ZID = Excutivemst.ZID
   
   
   UPDATE Salesmaster
INNER
  JOIN Itemmst
    ON Salesmaster.Product = Itemmst.Item_name
   SET Salesmaster.SKU = Itemmst.SKU,Salesmaster.SKU1 = Itemmst.SKU1
   
    UPDATE Salesmaster
INNER
  JOIN SKU
    ON Salesmaster.SKU = SKU.SKU
   SET Salesmaster.seqment = SKU.segment
   
   Select Salesmaster.amount,Salesmastermaster.amount
INNER
  JOIN Dealermst
    ON Salesmaster.State = Dealermst.D_state,Salesmastermaster.State = Dealermst.D_state
   
   
   UPDATE sales
INNER
  JOIN Dealermst
    ON sales.Dealer = Dealermst.D_name
   SET sales.state = Dealermst.D_state,sales.District = Dealermst.D_distict