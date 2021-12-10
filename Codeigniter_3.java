import java.lang.reflect.Method;

public class Codeigniter_3 {
    
    public String nomeTabela;
    public String nomeDataBase;
    // public String[] colunas;

    public Codeigniter_3(String nomeTabela){
        this.nomeTabela = nomeTabela;
    }
    // public Codeigniter_3(String nomeTabela, String[] colunas){
    //     this.nomeTabela = nomeTabela;
    //     this.colunas = colunas;
    // }
    public Codeigniter_3(String nomeTabela, String nomeDataBase){
        this.nomeTabela = nomeTabela;
        this.nomeDataBase = nomeDataBase;
    }

    public String init(){
        String model_crud = "";

        model_crud += this.create();
        model_crud += this.read();
        model_crud += this.update();
        model_crud += this.delete();

        return model_crud;
    }

    public String create(){
        String ci3_create = "";

        ci3_create += "public function insert($arr_insert){\n";
        if(this.nomeDataBase != null){
            ci3_create += "\t$otherdb = $this->load->database('" + this.nomeDataBase + "', TRUE);\n\n";
            ci3_create += "\t$otherdb->insert('" + this.nomeTabela + "', $arr_insert);\n\n";
            ci3_create += "\treturn $otherdb->affected_rows();\n";
        } else {
            ci3_create += "\t$this->db->insert('" + this.nomeTabela + "', $arr_insert);\n\n";
            ci3_create += "\treturn $this->db->affected_rows();\n";    
        }
        ci3_create += "}\n\n";

        return ci3_create;
    }
    public String read(){
        String ci3_read = "";

        ci3_read += "public function read($keyId){\n";
        if(this.nomeDataBase != null){
            ci3_read += "\t$otherdb = $this->load->database('" + this.nomeDataBase + "', TRUE);\n\n";
            ci3_read += "\t$otherdb->select('*');\n";
            ci3_read += "\t$otherdb->from('" + this.nomeTabela + "');\n";
            ci3_read += "\t$otherdb->where('COLUNA', $keyId);\n";
            ci3_read += "\t$linha = $otherdb->get()->result();\n\n";
            ci3_read += "\tif(empty($linha)){\n";
            ci3_read += "\t\treturn NULL;\n";
            ci3_read += "\t}\n\n";
            ci3_read += "\treturn $linha;\n";
        } else {
            ci3_read += "\t$this->db->select('*');\n";
            ci3_read += "\t$this->db->from('" + this.nomeTabela + "');\n";
            ci3_read += "\t$this->db->where('COLUNA', $keyId);\n";
            ci3_read += "\t$linha = $this->db->get()->result();\n\n";
            ci3_read += "\tif(empty($linha)){\n";
            ci3_read += "\t\treturn NULL;\n";
            ci3_read += "\t}\n\n";
            ci3_read += "\treturn $linha;\n";
        }
        ci3_read += "}\n\n";

        return ci3_read;
    }
    public String update(){
        String ci3_update = "";

        ci3_update += "public function update($arr_update, $keyId){\n";
        if(this.nomeDataBase != null){
            ci3_update += "\t$otherdb = $this->load->database('" + this.nomeDataBase + "', TRUE);\n\n";
            ci3_update += "\t$otherdb->update('" + this.nomeTabela + "', $arr_update);\n";
            ci3_update += "\t$otherdb->where('COLUNA', $keyId);\n\n";
            ci3_update += "\treturn $otherdb->affected_rows();\n";
        } else {
            ci3_update += "\t$this->db->update('" + this.nomeTabela + "', $arr_update);\n";
            ci3_update += "\t$this->db->where('COLUNA', $keyId);\n\n";
            ci3_update += "\treturn $this->db->affected_rows();\n";    
        }
        ci3_update += "}\n\n";

        return ci3_update;
    }
    public String delete(){
        String ci3_delete = "";

        ci3_delete += "public function delete($keyId){\n";
        if(this.nomeDataBase != null){
            ci3_delete += "\t$otherdb = $this->load->database('" + this.nomeDataBase + "', TRUE);\n\n";
            ci3_delete += "\t$otherdb->delete('" + this.nomeTabela + "');\n";
            ci3_delete += "\t$otherdb->where('COLUNA', $keyId);\n\n";
            ci3_delete += "\treturn $otherdb->affected_rows();\n";
        } else {
            ci3_delete += "\t$this->db->update('" + this.nomeTabela + "');\n";
            ci3_delete += "\t$this->db->where('COLUNA', $keyId);\n\n";
            ci3_delete += "\treturn $this->db->affected_rows();\n";    
        }
        ci3_delete += "}\n\n";

        return ci3_delete;
    }
}
