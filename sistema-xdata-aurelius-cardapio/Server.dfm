object frmserver: Tfrmserver
  Left = 0
  Top = 0
  Caption = 'Server'
  ClientHeight = 359
  ClientWidth = 447
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 13
  object SparkleHttpSysDispatcher1: TSparkleHttpSysDispatcher
    Active = True
    Left = 72
    Top = 24
  end
  object XDataServer1: TXDataServer
    BaseUrl = 'http://+:2001/tms/xdata'
    Dispatcher = SparkleHttpSysDispatcher1
    Pool = XDataConnectionPool1
    DefaultEntitySetPermissions = [List, Get, Insert, Modify, Delete]
    EntitySetPermissions = <>
    SwaggerOptions.Enabled = True
    SwaggerUIOptions.Enabled = True
    Left = 200
    Top = 24
    object XDataServer1CORS: TSparkleCorsMiddleware
    end
  end
  object AureliusConnection1: TAureliusConnection
    AdapterName = 'FireDac'
    AdaptedConnection = conn
    SQLDialect = 'Firebird'
    Params.Strings = (
      'Database=C:\db\dbteste.db')
    Left = 80
    Top = 112
  end
  object conn: TFDConnection
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
    Left = 208
    Top = 112
  end
  object FDTransaction1: TFDTransaction
    Connection = conn
    Left = 320
    Top = 112
  end
  object qrconsulta: TFDQuery
    Connection = conn
    Left = 80
    Top = 208
  end
  object XDataConnectionPool1: TXDataConnectionPool
    Connection = AureliusConnection1
    Left = 312
    Top = 24
  end
  object Script: TFDScript
    SQLScripts = <>
    Connection = conn
    Params = <>
    Macros = <>
    Left = 208
    Top = 208
  end
end