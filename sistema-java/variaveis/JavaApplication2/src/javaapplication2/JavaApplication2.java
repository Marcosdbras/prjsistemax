/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package javaapplication2;

/**
 *
 * @author WIN 8.1
 */
public class JavaApplication2 {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        /*TODO No java as variáveis são fortemente tipadas,ou seja, se você define uma variável de um determinado tipo ela não servirá para guardar informação de tipos inconsistentes.
         o valor atribuido à variável sempre deverá ser compatível com o tipo da variável
        Ex.1
        */
        //Declaração da variável
        int numeroInteiro;
        
        //Atribuicao da variável
        numeroInteiro = 50;
        
        //Exibição da variável no console
        System.out.println("O Valor é: "+numeroInteiro);
        
        //A variáel n foi criada e recebeu o valor 50 utilizando somente uma linha de código
        int n=50;
        
        
        /*
          
          Ex. 2
          
        */
        int n1 = n + 5;
        
        
        
        /*
        
        Ex. 3
        
        */
        int n2 = 0; 
        
        n2 = n2 + 1;
         
        
        /*
        
        Ex. 4
        
        */
        
        int n3 = 0;
        
        n3 += 5;
        
        int n4 = 0;
        
        n4 -= 1;        
        
        int n5 = 0;
        
        n5++;
        
        int n6 = 0;
        
        n6--;
        
        int n7 = 2;
        
        n7 *= 2;
        
        n7 /= 2;
        
        int i = 10 + 5;
        
        
        
        /* 
            int l = 10L + 5;

            Neste caso ocorre erro pois o resultado da operação será uma variável do tipo long
        
            int d = 5 * 2.0; 
        
            Neste caso também dará erro pois 2.0 é tipo double e este tipo é mais abrangente que o tipo int tal qual está sendo representado pelo número 5
        
            int n8 = 0 / 0;
        
            No caso acima ele compila porém ocorre uma exceção, isso nada mais é do que a ocorrência de um  erro durante a execução do código
        
            double d1 = 0.00 / 0;
        
            No caso acima o resultado é um NaN, apesar de não apresentar exceção o resultado será insatisfatório pois não é um número
        
            double d2 = 10.0 / 0
        
            No caso acima não teremos como resultado um número,porém teremos o resultado Infinity
        
            Concluindo, quando fizer divisão verificar se o divisor não é igual a zero, caso seja ocorrerá um dos três erros acima
        
        */
        long l = 10L + 5;
        
        double d = 5 * 2.0;
        
        
        
    }
    
}
