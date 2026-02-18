package com.jpa.demo.repository;

import com.jpa.demo.model.Veterinario;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface IVeterinario extends JpaRepository<Veterinario, Long> {
}
