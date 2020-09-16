object Form1: TForm1
  Left = 0
  Top = 0
  Width = 640
  Height = 480
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  TabOrder = 1
  OnShow = WebFormShow
  object WebEdit1: TWebEdit
    Left = 24
    Top = 8
    Width = 121
    Height = 19
    Text = '5'
  end
  object WebEdit2: TWebEdit
    Left = 24
    Top = 33
    Width = 121
    Height = 19
    ChildOrder = 1
    Text = '7'
  end
  object WebButton1: TWebButton
    Left = 151
    Top = 8
    Width = 96
    Height = 44
    Caption = 'Resultado'
    ChildOrder = 2
    OnClick = WebButton1Click
  end
  object WebDBTableControl1: TWebDBTableControl
    Left = 24
    Top = 58
    Width = 577
    Height = 200
    ElementClassName = '.table table-striped'
    BorderColor = clSilver
    ChildOrder = 3
    Columns = <>
    DataSource = WebDataSource1
  end
  object XDataWebConnection1: TXDataWebConnection
    URL = 'http://localhost:2001/tms/xdata'
    Connected = True
    Left = 48
    Top = 280
  end
  object XDataWebClient1: TXDataWebClient
    Connection = XDataWebConnection1
    OnLoad = XDataWebClient1Load
    Left = 200
    Top = 272
  end
  object XDataWebDataSet1: TXDataWebDataSet
    EntitySetName = 'usuarios'
    Connection = XDataWebConnection1
    Left = 352
    Top = 272
    object XDataWebDataSet1codigo: TIntegerField
      FieldName = 'codigo'
      Required = True
    end
    object XDataWebDataSet1nomeusuario: TStringField
      FieldName = 'nomeusuario'
      Size = 40
    end
    object XDataWebDataSet1email: TStringField
      FieldName = 'email'
      Size = 100
    end
    object XDataWebDataSet1telefone: TStringField
      FieldName = 'telefone'
    end
    object XDataWebDataSet1tipousuario: TStringField
      FieldName = 'tipousuario'
    end
    object XDataWebDataSet1celular: TStringField
      FieldName = 'celular'
    end
  end
  object WebDataSource1: TWebDataSource
    DataSet = XDataWebDataSet1
    Left = 496
    Top = 272
  end
end
