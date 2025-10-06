<?php
/**
 * @author CHRISTOPHER
 */
declare(strict_types=1); // Declaración de tipos estricta

class Session {
    public string $session_id;
    public string $alcance = "NOIDENTIFICADO";

    public function __construct(string $nombre) {
        $this->alcance = $nombre;
        $this->session_id = session_id();
    }

    public function getSession(): string {
        return $this->session_id;
    }

    public function getValueSession(string|array $name, bool $type = false) {
        $retorna = "";
        $bool_pasa = false;
        $bool_pasa_a = false;
        if (is_array($name)) {
            $idname = $name;
            $bool_pasa = true;
            $bool_pasa_a = false;
        } else {
            $idname = trim($name . "");
            if ($idname !== "") {
                $bool_pasa = true;
            }
            $bool_pasa_a = isset($_SESSION[$this->alcance][$idname]);
        }
        if ($bool_pasa && $bool_pasa_a) {
            $retorna = $_SESSION[$this->alcance][$idname];
        } else {
            if (!$type) {
                $retorna = "";
            } else {
                $retorna = false;
            }
        }
        return $retorna;
    }

    public function setValueSession(string $name, $value): void {
        $idname = trim($name);
        if ($idname !== "") {
            $_SESSION[$this->alcance][$idname] = $value;
        }
    }

    public function unsetSession(string $name): void {
        $idname = trim($name);
        if ($idname !== "" && isset($_SESSION[$this->alcance][$idname])) {
            unset($_SESSION[$this->alcance][$idname]);
        }
    }

    public function getAll(bool $type = false) {
        if (isset($_SESSION[$this->alcance])) {
            return $_SESSION[$this->alcance];
        } else {
            if (!$type) {
                return "";
            } else {
                return false;
            }
        }
    }

    public function setValueItemSession(string $name, string $item, $value): void {
        $idname = trim($name);
        $idiname = trim($item);
        if ($idname !== "" && $idiname !== "") {
            if (!isset($_SESSION[$this->alcance][$name])) {
                $_SESSION[$this->alcance][$name] = array();
            }
            $_SESSION[$this->alcance][$idname][$item] = $value;
        }
    }

    public function setAll(array $session_aux): void {
        if (isset($_SESSION[$this->alcance])) {
            $_SESSION[$this->alcance] = $session_aux;
        }
    }
}
