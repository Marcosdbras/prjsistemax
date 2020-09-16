object v: Tv
  OldCreateOrder = False
  Height = 261
  Width = 353
  object FDConnection1: TFDConnection
    Params.Strings = (
      'Database=C:\cardapio\db\DBCARDAPIO.FDB'
      'User_Name=SYSDBA'
      'Password=masterkey'
      'Protocol=TCPIP'
      'Port=3050'
      'CharacterSet=ISO8859_1'
      'Server=localhost'
      'DriverID=FB')
    Connected = True
    LoginPrompt = False
    Left = 88
    Top = 56
  end
  object FDTransaction1: TFDTransaction
    Connection = FDConnection1
    Left = 168
    Top = 104
  end
  object qrconsulta: TFDQuery
    Connection = FDConnection1
    Left = 80
    Top = 144
  end
  object Script: TFDScript
    SQLScripts = <>
    Connection = FDConnection1
    Params = <>
    Macros = <>
    Left = 208
    Top = 208
  end
end
