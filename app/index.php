<%@page import="com.servico.folhaPagamento.FolhaDePagamentoService"%>
<%@page contentType="text/html" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Folha de Pagamento</title>
    </head>
    <body>
        <h1>Calcular Folha de Pagamento</h1>
        
        <form action="index.jsp" method="post">
            Nome: <input type="text" name="nome"/><br/>
            CPF: <input type="text" name="cpf"/><br/>
            Salário Mensal: <input type="text" name="salarioMensal"/><br/>
            Horas Trabalhadas: <input type="text" name="horasTrabalhadas"/><br/>
            Tipo de Trabalhador: 
            <select name="tipoTrabalhador">
                <option value="CLT">CLT</option>
                <option value="Autonomo">Autônomo</option>
                <option value="PJ">PJ</option>
            </select><br/><br/>
            <input type="submit" value="Calcular"/>
        </form>

        <%
            // Verifica se os dados foram submetidos
            if (request.getMethod().equalsIgnoreCase("POST")) {
                String nome = request.getParameter("nome");
                String cpf = request.getParameter("cpf");
                double salarioMensal = Double.parseDouble(request.getParameter("salarioMensal"));
                int horasTrabalhadas = Integer.parseInt(request.getParameter("horasTrabalhadas"));
                String tipoTrabalhador = request.getParameter("tipoTrabalhador");

                // Invoca o Web Service
                FolhaDePagamentoService service = new FolhaDePagamentoService();
                String resultado = service.calcularFolhaPagamento(nome, cpf, salarioMensal, horasTrabalhadas, tipoTrabalhador);

                // Exibe o resultado na página
                out.println("<h2>Resultado da Folha de Pagamento</h2>");
                out.println("<pre>" + resultado + "</pre>");
            }
        %>
    </body>
</html>
