package com.jpa.demo.service;

import com.jpa.demo.model.Veterinario;

import java.util.List;

public interface IVeterinarioService {
    public List<Veterinario> getVeterinario();

    public void saveVeterinario(Veterinario veterinario);

    public Veterinario findVeterinario(Long id);

    public void deleteVeterinario(Long id);

    public Veterinario editVeterinario(Veterinario veterinario);

}
