object frmprincipal: Tfrmprincipal
  Left = 0
  Top = 0
  Caption = 'Card'#225'pio Digital'
  ClientHeight = 396
  ClientWidth = 764
  Color = clBtnFace
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  Menu = MainMenu1
  OldCreateOrder = False
  OnCreate = FormCreate
  OnDestroy = FormDestroy
  PixelsPerInch = 96
  TextHeight = 13
  object btnConexao: TButton
    Left = 685
    Top = 8
    Width = 71
    Height = 25
    Caption = 'Conex'#227'o'
    TabOrder = 0
    Visible = False
    OnClick = btnConexaoClick
  end
  object StatusBar1: TStatusBar
    Left = 0
    Top = 377
    Width = 764
    Height = 19
    Panels = <
      item
        Width = 100
      end
      item
        Width = 50
      end>
  end
  object MainMenu1: TMainMenu
    Left = 72
    Top = 40
    object Ca1: TMenuItem
      Caption = '&Cadastro'
      object Usurios1: TMenuItem
        Caption = '&Usu'#225'rios'
        OnClick = Usurios1Click
      end
    end
  end
end
