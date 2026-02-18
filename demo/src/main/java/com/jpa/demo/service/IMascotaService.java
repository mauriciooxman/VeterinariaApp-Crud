package com.jpa.demo.service;

import com.jpa.demo.model.Mascota;
import com.jpa.demo.repository.IMascota;

import java.util.List;

public interface IMascotaService {
    public List<Mascota> getMascota();

    public void saveMascota(Mascota mascota);

    public Mascota findMascota(Long id);

    public void deleteMascota(Long id);

    public Mascota editMascota(Mascota mascota);

}
