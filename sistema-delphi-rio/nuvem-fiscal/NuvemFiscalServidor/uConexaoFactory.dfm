object frmConexaoFactory: TfrmConexaoFactory
  OldCreateOrder = True
  Height = 246
  Width = 427
  object fbdados: TFDConnection
    Params.Strings = (
      'Database=C:\db\NUVEMFISCAL.FDB'
      'User_Name=SYSDBA'
      'Password=masterkey'
      'Protocol=TCPIP'
      'Server=localhost'
      'Port=3050'
      'CharacterSet=UTF8'
      'DriverID=FB')
    Left = 64
    Top = 8
  end
  object aDados: TAureliusConnection
    AdapterName = 'FireDac'
    AdaptedConnection = fbdados
    SQLDialect = 'Firebird'
    Left = 64
    Top = 64
  end
end
