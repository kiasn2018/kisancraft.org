UPDATE Salesmaster
INNER
  JOIN Excutivemst
    ON Salesmaster.District = Excutivemst.District 
   SET Salesmaster.Executive = Excutivemst.Exexutive,Salesmaster.EID = Excutivemst.EID,Salesmaster.ASM = Excutivemst.ASM,Salesmaster.AID = Excutivemst.AID,Salesmaster.SM = Excutivemst.SM,Salesmaster.SID = Excutivemst.SID,Salesmaster.ZM = Excutivemst.ZM,Salesmaster.ZID = Excutivemst.ZID
   
   
   UPDATE Salesmaster
INNER
  JOIN Itemmst
    ON Salesmaster.Product = Itemmst.Item_name
   SET Salesmaster.SKU = Itemmst.SKU