package com.jpa.demo.controller;

import com.jpa.demo.model.Veterinario;
import com.jpa.demo.service.VeterinarioService;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/veterinarios")
@CrossOrigin(origins = "*")
public class VeterinarioController {
    public final VeterinarioService veterinarioService;

    public VeterinarioController(VeterinarioService veterinarioService) {
        this.veterinarioService = veterinarioService;
    }

    @GetMapping
    public List<Veterinario> getVeterinarios() {
        return veterinarioService.getVeterinario();
    }

    @GetMapping("/{id}")
    public Veterinario traerVeterinarioPorId(@PathVariable Long id) {
        return veterinarioService.findVeterinario(id);
    }

    @PostMapping
    public void saveVeterinario(@RequestBody Veterinario veterinario) {
        veterinarioService.saveVeterinario(veterinario);
    }

    @DeleteMapping("/{id}")
    public void deleteVeterinario(@PathVariable Long id) {
        veterinarioService.deleteVeterinario(id);
    }

    @PutMapping("/editar")
    public Veterinario editVeterinario(@RequestBody Veterinario veterinario) {
        veterinarioService.editVeterinario(veterinario);
        return veterinarioService.findVeterinario(veterinario.getId());
    }
}
