import java.io.FileOutputStream;

public class Main {

    public static void print_man(){
        System.out.println("\n===================================================");
        System.out.println("Gerador de CRUD - Autor David Faria");
        System.out.println("===================================================");
        System.out.println("--man: abre manual");
        System.out.println("Argumento 1 (obrigatorio): nome da tabela");
        System.out.println("Argumento 2 (opcional): nome do banco de dados");
        System.out.println("Argumento 3 (opcional): nome do arquivo output");
        System.out.println("===================================================\n");
        System.out.println("Todos os outputs de CRUD sao feito por padrao noseguinte caminho: ./output/gerador_crud_CI3.txt");
        System.out.println("===================================================\n");
        // System.out.println("Argumento 3: nome das colunas");
    }

    public static void main(String[] args) {

        for (String string : args) {
            System.out.println(string);
        }

        switch (args[0]) {
            case "--man":
                print_man();
                break;

            default:

                Codeigniter_3 ci3;
                String nomeTabela, nomeDataBase, fileNameOutput;

                fileNameOutput = (args.length == 3) ? args[2] : "gerador_crud_CI3.txt";

                // inicializando gerador de Crud com seus respectivos argumentos
                if (args.length == 2) {
                    nomeTabela = args[0];
                    nomeDataBase = args[1];
                    ci3 = new Codeigniter_3(nomeTabela, nomeDataBase);
                } else {
                    nomeTabela = args[0];
                    ci3 = new Codeigniter_3(nomeTabela);
                }

                String model = ci3.init();

                try {
                    FileOutputStream fos = new FileOutputStream("./output/" + fileNameOutput);
                    fos.write(model.getBytes());
                    fos.close();
                } catch (Exception e) {
                    System.out.println(e);
                }
                break; // end of default:
        }

    }
}
