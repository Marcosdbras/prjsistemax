/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package br.com.sistemax.conexaodb;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLXML.*;

/**
 *
 * @author WIN 8.1
 */
public class ModuloConexao {
    //Conexão

    public static Connection conector() {

        java.sql.Connection conexao = null;
        String driver = "com.mysql.jdbc.Driver";
        //String url = "jdbc:mysql://raosistemas.dyndns.org:3306/magazine";
        //String url = "jdbc:mysql://response.magazineloocalmais.com.br:3306/magazine";
        String url = "jdbc:mysql://response.magazineloocalmais.com.br:3306/magazine?useTimezone=true&serverTimezone=UTC&useSSL=false";
        
        String user = "rao";
        String password = "data3001";
        try {
            Class.forName(driver);
            conexao = DriverManager.getConnection(url,user,password);
            return conexao;
        } catch (Exception e) {
            //System.out.println(e);
            
            return null;
        }
    }
}
