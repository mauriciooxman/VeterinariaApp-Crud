package com.jpa.demo.service;

import com.jpa.demo.model.Usuario;

import java.util.List;

public interface IUsuarioService {
    public List<Usuario> getUsuario();
    public void saveUsuario(Usuario usuario);
    public Usuario findUsuario(Long id);
    public void deleteUsuario(Long id);
    public Usuario editUsuario(Usuario usuario);
}
