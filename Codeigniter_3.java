import java.lang.reflect.Method;

public class Codeigniter_3 {
    
    public String nomeTabela;
    public String nomeDataBase;

    public Codeigniter_3(String nomeTabela){
        this.nomeTabela = nomeTabela;
    }
    public Codeigniter_3(String nomeTabela, String nomeDataBase){
        this.nomeTabela = nomeTabela;
        this.nomeDataBase = nomeDataBase;
    }

    public String create(){
        String ci3_create = "";

        ci3_create += "public function insert($arr_insert){\n";
        if(this.nomeDataBase != null){
            ci3_create += "\t$otherdb = $this->load->database('" + this.nomeDataBase + "', TRUE);\n";
            ci3_create += "\t$otherdb->insert('" + this.nomeTabela + "', $arr_insert);\n";
            ci3_create += "\treturn $otherdb->affected_rows();\n";
        } else {
            ci3_create += "\t$this-db->insert('" + this.nomeTabela + "', $arr_insert);\n";
            ci3_create += "\treturn $otherdb->affected_rows();\n";    
        }
        ci3_create += "}";

        return ci3_create;
    }
    public String read(){ // todp
        String ci3_read = "";
    
        ci3_read += "public function read($arr_insert){\n";
        if(this.nomeDataBase != null){
            ci3_read += "\t$otherdb = $this->load->database('" + this.nomeDataBase + "', TRUE);\n";
            ci3_read += "\t$otherdb->insert('" + this.nomeTabela + "', $arr_insert);\n";
            ci3_read += "\treturn $otherdb->affected_rows();\n";
        } else {
            ci3_read += "\t$this-db->insert('" + this.nomeTabela + "', $arr_insert);\n";
            ci3_read += "\treturn $otherdb->affected_rows();\n";    
        }
        ci3_read += "}";
    
        return ci3_read;
    }
    public String update(){
        return "";
    }
    public String delete(){
        return "";
    }
}
