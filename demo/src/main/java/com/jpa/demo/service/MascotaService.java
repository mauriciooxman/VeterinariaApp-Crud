package com.jpa.demo.service;

import com.jpa.demo.model.Mascota;
import com.jpa.demo.repository.IMascota;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class MascotaService implements IMascotaService{

    public final IMascota iMascotaRepository;

    public MascotaService(IMascota iMascotaRepository) {
        this.iMascotaRepository = iMascotaRepository;
    }


    @Override
    public List<Mascota> getMascota() {
        List<Mascota> listasMascota = iMascotaRepository.findAll();
        return listasMascota;
    }

    @Override
    public void saveMascota(Mascota mascota) {
    iMascotaRepository.save(mascota);
    }

    @Override
    public Mascota findMascota(Long id) {
      Mascota mascota = iMascotaRepository.findById(id).orElse(null);
      return mascota;

    }

    @Override
    public void deleteMascota(Long id) {
        iMascotaRepository.deleteById(id);
    }

    @Override
    public Mascota editMascota(Mascota mascota) {
        this.saveMascota(mascota); //si existe id edita, si no existe id inserta
        return mascota;
    }
}
