unit uresumo;

interface

uses
  System.SysUtils, System.Types, System.UITypes, System.Classes, System.Variants,
  FMX.Types, FMX.Controls, FMX.Forms, FMX.Graphics, FMX.Dialogs, FMX.Objects,
  FMX.Controls.Presentation, FMX.StdCtrls, FMX.ListView.Types,
  FMX.ListView.Appearances, FMX.ListView.Adapters.Base, FMX.ListView,
  FMX.Layouts, FMX.Dialogservice;

type
  Tfrmresumo = class(TForm)
    rctacesso: TRectangle;
    lblcabecalho: TLabel;
    Image1: TImage;
    Image2: TImage;
    Rectangle1: TRectangle;
    Label1: TLabel;
    Layout1: TLayout;
    lblncomanda: TLabel;
    rctencerrar: TRectangle;
    lblencerrar: TLabel;
    Rectangle2: TRectangle;
    Label2: TLabel;
    lsvproduto: TListView;
    imgaddproduct: TImage;
    img_delete: TImage;
    procedure Image1Click(Sender: TObject);
    procedure FormClose(Sender: TObject; var Action: TCloseAction);
    procedure AddItem(ncomanda:integer);
    procedure Image2Click(Sender: TObject);
    procedure rctencerrarClick(Sender: TObject);


    procedure AddProdutoListView(id:integer;qtde:double ;descricao:string;preco:double);
    procedure ListaProduto;
    procedure FormShow(Sender: TObject);



  private
    { Private declarations }
  public
    { Public declarations }
    ncomanda:integer;
  end;

var
  frmresumo: Tfrmresumo;

implementation

{$R *.fmx}

uses uadditem;

procedure Tfrmresumo.AddItem(ncomanda: integer);
begin
 if not Assigned(frmadditem) then
     Application.CreateForm(tfrmadditem,frmadditem);

     frmadditem.ncomanda := ncomanda;
     frmadditem.lblsubtitulo1.Text := 'Comanda / Mesa : '+ncomanda.ToString;

  frmAddItem.Show;
end;

procedure Tfrmresumo.AddProdutoListView(id: integer; qtde: double;
  descricao: string; preco: double);
begin
   with lsvproduto.Items.Add do
       begin

          tag := id;

          TListItemText(  objects.FindDrawable('txtdescricao')).Text  :=   formatfloat('##0.000', qtde)+ ' X ' + descricao;
          TListItemText(  objects.FindDrawable('txtpreco')).Text  := formatfloat('###,##0.00',qtde * preco);

          TListItemImage(  objects.FindDrawable('imgdelete')).Bitmap := img_delete.Bitmap;

       end;
end;

procedure Tfrmresumo.FormClose(Sender: TObject; var Action: TCloseAction);
begin
//limpa memória /  garbage
action := tcloseaction.caFree;
frmresumo := nil;
end;

procedure Tfrmresumo.FormShow(Sender: TObject);
begin
  ListaProduto;
end;

procedure Tfrmresumo.Image1Click(Sender: TObject);
begin
   close;
end;

procedure Tfrmresumo.Image2Click(Sender: TObject);
begin
  additem(ncomanda);
end;

procedure Tfrmresumo.ListaProduto;
 var
   x:integer;
begin

     lsvproduto.items.Clear;

//Buscar Dados no Servidor
for x := 1 to 10 do
  AddProdutolistview(x,x*1.598,'Produto '+x.ToString,x);

end;

procedure Tfrmresumo.rctencerrarClick(Sender: TObject);
begin
   TDialogService.MessageDialog('Deseja realmente encerrar esta comanda ou mesa?',TMsgDlgType.mtConfirmation,[TMsgDlgBtn.mbYes,TMsgDlgBtn.mbNo],TMsgDlgBtn.mbNo,0,procedure(const AResult:TModalResult)begin

            if AResult = mrYes then
               showmessage('Encerramento concluido!');



   end);
end;

end.
