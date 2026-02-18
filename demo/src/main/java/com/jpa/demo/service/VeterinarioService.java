package com.jpa.demo.service;

import com.jpa.demo.model.Veterinario;
import com.jpa.demo.repository.IVeterinario;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class VeterinarioService implements IVeterinarioService {

    public final IVeterinario iVeterinarioRepository;

    public VeterinarioService(IVeterinario iVeterinarioRepository) {
        this.iVeterinarioRepository = iVeterinarioRepository;
    }

    @Override
    public List<Veterinario> getVeterinario() {
        List<Veterinario> listasVeterinario = iVeterinarioRepository.findAll();
        return listasVeterinario;
    }

    @Override
    public void saveVeterinario(Veterinario veterinario) {
        iVeterinarioRepository.save(veterinario);
    }

    @Override
    public Veterinario findVeterinario(Long id) {
        Veterinario veterinario = iVeterinarioRepository.findById(id).orElse(null);
        return veterinario;

    }

    @Override
    public void deleteVeterinario(Long id) {
        iVeterinarioRepository.deleteById(id);
    }

    @Override
    public Veterinario editVeterinario(Veterinario veterinario) {
        this.saveVeterinario(veterinario); // si existe id edita, si no existe id inserta
        return veterinario;
    }
}
