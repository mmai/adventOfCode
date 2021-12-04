use std::env;
use std::fs;

fn main() {
    let contents = fs::read_to_string("day3.txt")
        .expect("Something went wrong reading the file");

    let width = 31;
    let (total_counts, _x) = contents.lines().fold((SlopCounts::new(), true), |(scounts, is_odd), line| {
        let chars_list: Vec<char> = line.chars().collect();

        let new_scount = SlopCounts {
            s1: SlopCounts::count_tree(&chars_list, scounts.s1, 1),
            s3: SlopCounts::count_tree(&chars_list, scounts.s3, 3),
            s5: SlopCounts::count_tree(&chars_list, scounts.s5, 5),
            s7: SlopCounts::count_tree(&chars_list, scounts.s7, 7),
            s1odd: if is_odd {SlopCounts::count_tree(&chars_list, scounts.s1odd, 1)} else { scounts.s1odd },
        };
        (new_scount, !is_odd)
    });
    println!("total : {:?}", total_counts.calculate());
}

struct SlopCounts {
    pub s1: (usize, usize),
    pub s3: (usize, usize),
    pub s5: (usize, usize),
    pub s7: (usize, usize),
    pub s1odd: (usize, usize),
}

impl SlopCounts {
    pub fn new() -> Self{
        SlopCounts {
            s1: (0, 0),
            s3: (0, 0),
            s5: (0, 0),
            s7: (0, 0),
            s1odd: (0, 0),
        }
    }

    pub fn calculate(self) -> usize {
        self.s1.0 * self.s3.0 * self.s5.0 * self.s7.0 * self.s1odd.0
    }

    pub fn count_tree(chars_list: &Vec<char>, count_pos: (usize, usize), step: usize) -> (usize, usize) {
        let width = chars_list.len();
        (
            if chars_list[ count_pos.1 % width] == '#' { count_pos.0 + 1 } else { count_pos.0 },
            count_pos.1 + step
        )
    }
}
