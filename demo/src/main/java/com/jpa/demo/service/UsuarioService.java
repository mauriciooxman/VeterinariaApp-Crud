package com.jpa.demo.service;

import com.jpa.demo.model.Mascota;
import com.jpa.demo.model.Usuario;
import com.jpa.demo.repository.IMascota;
import com.jpa.demo.repository.IUsuario;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Objects;


@Service
public class UsuarioService implements IUsuarioService {

    public final IUsuario iUsuarioRepository;
    public final IMascota iMascotaRepository;

    public UsuarioService(IUsuario iUsuarioRepository, IMascota iMascotaRepository) {
        this.iUsuarioRepository = iUsuarioRepository;
        this.iMascotaRepository = iMascotaRepository;
    }

    @Override
    public List<Usuario> getUsuario() {
        List<Usuario>treaerListaUsuario = iUsuarioRepository.findAll();
        return treaerListaUsuario;
    }

    @Override
    public void saveUsuario(Usuario usuario) {
        Usuario usuarioGuardado = iUsuarioRepository.save(usuario);

        Long mascotaSeleccionadaId = null;
        if (usuario.getMascotas() != null && !usuario.getMascotas().isEmpty()) {
            mascotaSeleccionadaId = usuario.getMascotas().get(0).getId();
        }

        Usuario usuarioActual = iUsuarioRepository.findById(usuarioGuardado.getId()).orElse(usuarioGuardado);
        if (usuarioActual.getMascotas() != null) {
            for (Mascota mascotaActual : usuarioActual.getMascotas()) {
                if (mascotaSeleccionadaId == null || !Objects.equals(mascotaActual.getId(), mascotaSeleccionadaId)) {
                    mascotaActual.setDuenio(null);
                    iMascotaRepository.save(mascotaActual);
                }
            }
        }

        if (mascotaSeleccionadaId != null) {
            Mascota mascota = iMascotaRepository.findById(mascotaSeleccionadaId).orElse(null);
            if (mascota != null) {
                mascota.setDuenio(usuarioGuardado);
                iMascotaRepository.save(mascota);
            }
        }

    }

    @Override
    public Usuario findUsuario(Long id) {
        Usuario usuario = iUsuarioRepository.findById(id).orElse(null);
        return usuario;

    }

    @Override
    public void deleteUsuario(Long id) {
    iUsuarioRepository.deleteById(id);
    }

    @Override
    public Usuario editUsuario(Usuario usuario) {
        this.saveUsuario(usuario); //save si hay id es update, si no es insert
        return usuario;
    }


}
