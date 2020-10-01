object DM: TDM
  OldCreateOrder = False
  OnCreate = DataModuleCreate
  Height = 448
  Width = 757
  object Conn: TFDConnection
    Params.Strings = (
      
        'Database=C:\Users\WIN 8.1\Documents\sistemas\sistema-comanda\mob' +
        'ile\DB\comanda_eletronica.db'
      'OpenMode=ReadWrite'
      'LockingMode=Normal'
      'DriverID=SQLite')
    LoginPrompt = False
    Left = 32
    Top = 16
  end
  object Query: TFDQuery
    Connection = Conn
    Left = 120
    Top = 16
  end
  object RESTClient: TRESTClient
    Authenticator = HTTPBasicAuth
    Accept = 'application/json, text/plain; q=0.9, text/html;q=0.8,'
    AcceptCharset = 'utf-8, *;q=0.8'
    BaseURL = 'http://localhost:8082'
    Params = <>
    RaiseExceptionOn500 = False
    Left = 24
    Top = 96
  end
  object RequestLogin: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'login'
    SynchronizedEvents = False
    Left = 24
    Top = 168
  end
  object HTTPBasicAuth: THTTPBasicAuthenticator
    Username = 'adm'
    Password = '123'
    Left = 136
    Top = 96
  end
  object RequestListarComandas: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'listarcomandas'
    SynchronizedEvents = False
    Left = 88
    Top = 208
  end
  object RequestListarProdutos: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'listarprodutos'
    SynchronizedEvents = False
    Left = 168
    Top = 168
  end
  object RequestListarGrupos: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'listargrupos'
    SynchronizedEvents = False
    Left = 320
    Top = 160
  end
  object RequestAddProdutoComanda: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'addprodutocomanda'
    SynchronizedEvents = False
    Left = 520
    Top = 160
  end
  object RequestexcluirProdutoComanda: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'excluirProdutoComanda'
    SynchronizedEvents = False
    Left = 272
    Top = 56
  end
  object RequestEncerrarComanda: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'encerrarcomanda'
    SynchronizedEvents = False
    Left = 448
    Top = 56
  end
  object RequestListarProdutosComanda: TRESTRequest
    Client = RESTClient
    Method = rmPOST
    Params = <
      item
        Name = 'login'
        Value = '99@99999.com.br'
      end
      item
        Name = 'senha'
        Value = 'c4ca4238a0b923820dcc509a6f75849b'
      end>
    Resource = 'listarprodutoscomanda'
    SynchronizedEvents = False
    Left = 408
    Top = 192
  end
end
