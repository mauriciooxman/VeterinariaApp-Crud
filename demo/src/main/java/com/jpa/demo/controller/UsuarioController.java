package com.jpa.demo.controller;


import com.jpa.demo.model.Usuario;
import com.jpa.demo.service.UsuarioService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/usuario")
@CrossOrigin(origins = "*")
public class UsuarioController {
    public final UsuarioService usuarioService;

    public UsuarioController(UsuarioService usuarioService) {
        this.usuarioService = usuarioService;
    }


    @GetMapping
    public List<Usuario> traerListaUsuario(){
        return usuarioService.getUsuario();
    }

    @GetMapping("/{id}")
    public Usuario traerUsuarioId(@PathVariable Long id){
        return usuarioService.findUsuario(id);

    }

    @PostMapping
    public void saveUsuario(@RequestBody Usuario usuario){
        usuarioService.saveUsuario(usuario);

    }

    @DeleteMapping("/{id}")
    public void deleteUsuario(@PathVariable Long id){
        usuarioService.deleteUsuario(id);
    }

    @PutMapping("/editar")
public Usuario editUsuario(@RequestBody Usuario usuario){
        usuarioService.editUsuario(usuario);
        return usuarioService.findUsuario(usuario.getId());
    }

}
