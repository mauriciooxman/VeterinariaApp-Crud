package com.jpa.demo.controller;


import com.jpa.demo.model.Mascota;
import com.jpa.demo.service.MascotaService;
import jakarta.persistence.criteria.CriteriaBuilder;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/mascotas")
@CrossOrigin(origins = "*")
public class MascotaController {
    public final MascotaService mascotaService;

    public MascotaController(MascotaService mascotaService) {
        this.mascotaService = mascotaService;
    }

    @GetMapping
    public List<Mascota> getMascotas(){
    return mascotaService.getMascota();
    }

    @GetMapping("/{id}")
    public Mascota traerMascotaPorId(@PathVariable Long id){
        return mascotaService.findMascota(id);
    }

    @PostMapping
    public void saveMascota(@RequestBody Mascota mascota){
        mascotaService.saveMascota(mascota);
    }

    @DeleteMapping("/{id}")
    public void deleteMascota(@PathVariable Long id){
        mascotaService.deleteMascota(id);
    }

    @PutMapping("/editar")
    public Mascota editMascota(@RequestBody Mascota mascota){
        mascotaService.editMascota(mascota);
        return mascotaService.findMascota(mascota.getId());
    }
}
